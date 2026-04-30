<?php

namespace App\Proxy\Flight\Providers;

use App\Proxy\Flight\FlightProvider;
use App\Proxy\Flight\UnifiedFlight;
use App\Services\AmadeusSoapService;
use Illuminate\Support\Facades\Log;

class AmadeusProvider implements FlightProvider
{
    protected $amadeusSoap;

    public function __construct(AmadeusSoapService $amadeusSoap)
    {
        $this->amadeusSoap = $amadeusSoap;
    }

    public function getName(): string { return 'amadeus'; }
    public function supportsBooking(): bool { return true; }

    public function search(array $params): array
    {
        $origin = $params['from'] ?? 'DEL';
        $destination = $params['to'] ?? 'BOM';
        $date = $params['date'] ?? date('Y-m-d');
        $paxCount = $params['adults'] ?? 1;

        $response = $this->amadeusSoap->searchFlightsStateless($origin, $destination, $date, $paxCount);

        if (isset($response['error']) || isset($response['Body']['Fault'])) {
            Log::error('AmadeusProvider: SOAP Search Error', ['response' => $response]);
            return ['flights' => [], 'meta' => []];
        }

        $reply = $response['Body']['Fare_MasterPricerTravelBoardSearchReply'] ?? null;
        
        if (!$reply) {
            Log::info('AmadeusProvider: No Reply found in SOAP response');
            return ['flights' => [], 'meta' => []];
        }

        if (isset($reply['errorMessage'])) {
            Log::info('AmadeusProvider: Amadeus returned business error', ['error' => $reply['errorMessage']]);
            return ['flights' => [], 'meta' => []];
        }

        Log::info('AmadeusProvider: Reply Content Keys', ['keys' => array_keys($reply)]);

        return $this->mapSoapResponse($reply);
    }

    protected function mapSoapResponse($reply)
    {
        $unified = [];
        Log::info('AmadeusProvider: Recommendations count in mapper', ['count' => count($reply['recommendation'] ?? [])]);
        
        // Normalize FlightIndex
        $flightIndex = $reply['flightIndex'] ?? [];
        if (isset($flightIndex['groupOfFlights'])) {
            $flightIndex = [$flightIndex];
        }

        // Normalize Recommendations
        $recommendations = $reply['recommendation'] ?? [];
        if (isset($recommendations['itemNumber'])) {
            $recommendations = [$recommendations];
        }

        foreach ($recommendations as $rec) {
            $recId = $rec['itemNumber']['itemNumber'] ?? uniqid();
            $price = (float) ($rec['recPriceInfo']['monetaryDetail']['amount'] ?? 0);
            
            // Normalize paxFareProduct
            $paxFareProducts = $rec['paxFareProduct'] ?? [];
            if (isset($paxFareProducts['fareDetails'])) {
                $paxFareProducts = [$paxFareProducts];
            }
            
            if (empty($paxFareProducts)) {
                Log::info('AmadeusProvider: Recommendation has no paxFareProduct', ['rec_id' => $recId, 'keys' => array_keys($rec)]);
            }

            foreach ($paxFareProducts as $fareProd) {
                $fareDetails = $fareProd['fareDetails'] ?? [];
                if (isset($fareDetails[0])) {
                    $fareDetails = $fareDetails[0]; 
                }

                $segRef = $fareDetails['segmentRef']['segRef'] ?? null;
                Log::info('AmadeusProvider: Checking segRef', ['segRef' => $segRef]);
                
                if (!$segRef) {
                    continue;
                }

                $flightDetailsGrp = $this->findFlightByIndex($flightIndex, $segRef);
                if (!$flightDetailsGrp) {
                    Log::info('AmadeusProvider: Flight Details not found for segRef', ['segRef' => $segRef]);
                    continue;
                }

                // Normalize flightDetails
                $flights = $flightDetailsGrp['flightDetails'] ?? [];
                if (isset($flights['flightInformation'])) {
                    $flights = [$flights];
                }

                $firstSeg = $flights[0];
                $lastSeg = end($flights);

                $unified[] = new UnifiedFlight([
                    'id' => 'amadeus_' . $recId . '_' . $segRef,
                    'airline_code' => $firstSeg['flightInformation']['companyId']['marketingCarrier'] ?? '??',
                    'airline_name' => $this->getAirlineName($firstSeg['flightInformation']['companyId']['marketingCarrier'] ?? ''),
                    'flight_number' => $firstSeg['flightInformation']['flightOrtrainNumber'] ?? '000',
                    'departure_at' => $this->parseAmadeusDate($firstSeg['flightInformation']['productDateTime']['dateOfDeparture'], $firstSeg['flightInformation']['productDateTime']['timeOfDeparture']),
                    'arrival_at' => $this->parseAmadeusDate($lastSeg['flightInformation']['productDateTime']['dateOfArrival'] ?? $firstSeg['flightInformation']['productDateTime']['dateOfDeparture'], $lastSeg['flightInformation']['productDateTime']['timeOfArrival'] ?? '0000'),
                    'departure_city' => $firstSeg['flightInformation']['location'][0]['locationId'] ?? '???',
                    'arrival_city' => $lastSeg['flightInformation']['location'][1]['locationId'] ?? '???',
                    'duration' => 'N/A', 
                    'stops' => count($flights) - 1,
                    'price' => $price,
                    'net_price' => $price,
                    'currency' => 'INR',
                    'cabin' => $fareProd['fareDetails']['groupOfFares']['productInformation']['cabinProduct']['cabin'] ?? 'M',
                    'baggage' => '15 KG', 
                    'source' => 'amadeus',
                    'raw_data' => $rec
                ]);
            }
        }

        Log::info('AmadeusProvider: Mapping complete', ['count' => count($unified)]);
        return ['flights' => $unified, 'meta' => []];
    }

    protected function findFlightByIndex($flightIndex, $ref)
    {
        foreach ($flightIndex as $group) {
            $groupFlights = $group['groupOfFlights'] ?? [];
            if (isset($groupFlights['propFlightGrDetail'])) {
                $groupFlights = [$groupFlights];
            }

            foreach ($groupFlights as $f) {
                $proposals = $f['propFlightGrDetail']['flightProposal'] ?? [];
                if (isset($proposals['unitQualifier'])) {
                    $proposals = [$proposals];
                }

                foreach ($proposals as $prop) {
                    $propRef = $prop['ref'] ?? null;
                    $qualifier = $prop['unitQualifier'] ?? null;
                    
                    if (($qualifier == 'REF' || empty($qualifier)) && $propRef == $ref) {
                        return $f;
                    }
                }
            }
        }
        return null;
    }

    protected function parseAmadeusDate($date, $time)
    {
        $d = substr($date, 0, 2);
        $m = substr($date, 2, 2);
        $y = '20' . substr($date, 4, 2);
        $h = substr($time, 0, 2);
        $i = substr($time, 2, 2);
        return "$y-$m-$d $h:$i:00";
    }

    private function getAirlineName($code)
    {
        $airlines = ['6E' => 'IndiGo', 'UK' => 'Vistara', 'AI' => 'Air India', 'SG' => 'SpiceJet', 'QP' => 'Akasa Air', 'G8' => 'Go First'];
        return $airlines[$code] ?? $code;
    }
}

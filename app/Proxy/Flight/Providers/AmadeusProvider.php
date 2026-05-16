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
        $paxCount = ($params['adults'] ?? 1) + ($params['children'] ?? 0);

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
            
            // Refined Price Extraction
            $price = 0;
            $monetary = $rec['recPriceInfo']['monetaryDetail'] ?? [];
            
            if (isset($monetary['amount'])) {
                $price = (float)$monetary['amount'];
            } elseif (is_array($monetary) && count($monetary) > 0) {
                // Look for '707' qualifier which usually means total price including taxes
                foreach ($monetary as $m) {
                    $qualifier = $m['amountQualifier'] ?? ($m['tier?'] ?? '');
                    if ($qualifier == '707' || $qualifier == '705') {
                        $price = (float)($m['amount'] ?? 0);
                        if ($price > 0) break;
                    }
                }
                // Fallback to first one if 707 not found
                if ($price == 0) {
                    $price = (float)($monetary[0]['amount'] ?? 0);
                }
            }
            
            // Normalize paxFareProduct
            $paxFareProducts = $rec['paxFareProduct'] ?? [];
            if (isset($paxFareProducts['fareDetails'])) {
                $paxFareProducts = [$paxFareProducts];
            }
            
            foreach ($paxFareProducts as $fareProd) {
                $fareDetails = $fareProd['fareDetails'] ?? [];
                if (isset($fareDetails[0])) {
                    $fareDetails = $fareDetails[0]; 
                }

                $segRef = $fareDetails['segmentRef']['segRef'] ?? null;
                if (!$segRef) continue;

                $flightDetailsGrp = $this->findFlightByIndex($flightIndex, $segRef);
                if (!$flightDetailsGrp) continue;

                // Normalize flightDetails
                $flights = $flightDetailsGrp['flightDetails'] ?? [];
                if (isset($flights['flightInformation'])) {
                    $flights = [$flights];
                }

                $firstSeg = $flights[0];
                $lastSeg = end($flights);

                $depAt = $this->parseAmadeusDate($firstSeg['flightInformation']['productDateTime']['dateOfDeparture'], $firstSeg['flightInformation']['productDateTime']['timeOfDeparture']);
                $arrAt = $this->parseAmadeusDate($lastSeg['flightInformation']['productDateTime']['dateOfArrival'] ?? $firstSeg['flightInformation']['productDateTime']['dateOfDeparture'], $lastSeg['flightInformation']['productDateTime']['timeOfArrival'] ?? '0000');
                
                // Calculate duration
                $duration = 'N/A';
                try {
                    $d1 = new \DateTime($depAt);
                    $d2 = new \DateTime($arrAt);
                    $diff = $d1->diff($d2);
                    $duration = ($diff->h + ($diff->days * 24)) . 'h ' . $diff->i . 'm';
                } catch (\Exception $e) {}

                // Try to get real cabin
                $cabin = $fareProd['fareDetails']['groupOfFares']['productInformation']['cabinProduct']['cabin'] ?? 'M';
                $cabinMap = ['M' => 'ECONOMY', 'W' => 'PREMIUM_ECONOMY', 'C' => 'BUSINESS', 'F' => 'FIRST'];
                $unifiedCabin = $cabinMap[$cabin] ?? 'ECONOMY';

                $unified[] = new UnifiedFlight([
                    'id' => 'amadeus_' . $recId . '_' . $segRef,
                    'airline_code' => $firstSeg['flightInformation']['companyId']['marketingCarrier'] ?? '??',
                    'airline_name' => $this->getAirlineName($firstSeg['flightInformation']['companyId']['marketingCarrier'] ?? ''),
                    'flight_number' => $firstSeg['flightInformation']['flightOrtrainNumber'] ?? '000',
                    'departure_at' => $depAt,
                    'arrival_at' => $arrAt,
                    'departure_city' => $firstSeg['flightInformation']['location'][0]['locationId'] ?? '???',
                    'arrival_city' => $lastSeg['flightInformation']['location'][1]['locationId'] ?? '???',
                    'terminal' => $firstSeg['flightInformation']['location'][0]['terminal'] ?? ($firstSeg['flightInformation']['location'][1]['terminal'] ?? 'T1'),
                    'duration' => $duration, 
                    'stops' => count($flights) - 1,
                    'price' => $price,
                    'net_price' => $price,
                    'currency' => 'INR',
                    'cabin' => $unifiedCabin,
                    'baggage' => '15 KG', // Fallback, SOAP MasterPricer sometimes doesn't return this in simple replies
                    'source' => 'amadeus',
                    'raw_data' => $rec
                ]);
            }
        }

        Log::info('AmadeusProvider: Mapping complete', ['count' => count($unified)]);
        return [
            'flights' => $unified,
            'raw_data' => array_map(fn($f) => $f->toArray(), $unified), 
            'meta' => []
        ];
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
        if (strlen($date) < 6) return date('Y-m-d H:i:s');
        if (strlen($time) < 4) $time = '0000';

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

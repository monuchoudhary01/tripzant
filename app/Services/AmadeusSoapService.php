<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AmadeusSoapService
{
    protected $config;
    protected $endpoint;
    protected $wsap;
    protected $username;
    protected $password;
    protected $officeId;

    public function __construct($region = 'IN')
    {
        $this->config = config("tripzant.amadeus.providers.{$region}");
        $this->wsap = $this->config['wsap'] ?? '1ASIWIBEESI'; 
        $this->username = $this->config['user'] ?? 'WSESIIBE';
        $this->password = $this->config['password'] ?? 'prWC5RnJ%ARx';
        $this->officeId = $this->config['pcc'] ?? 'JAIVS3793';
        
        $this->endpoint = "https://nodeD2.test.webservices.amadeus.com/1ASIWIBEESI";
    }

    private function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    private function getTimestamp() {
        return gmdate("Y-m-d\TH:i:s\Z");
    }

    private function getNonce() {
        return base64_encode(mt_rand());
    }

    private function getPasswordDigest($nonce, $timestamp, $password) {
        // EXACT LOGIC FROM WORKING TEST SCRIPT
        return base64_encode(sha1(base64_decode($nonce) . $timestamp . sha1($password, true), true));
    }

    public function searchFlightsStateless($origin, $destination, $date, $paxCount = 1)
    {
        $soapAction = "http://webservices.amadeus.com/FMPTBQ_24_6_1A"; 
        $messageId = $this->generateUUID();
        $timestamp = $this->getTimestamp();
        $nonce = $this->getNonce();
        $passwordDigest = $this->getPasswordDigest($nonce, $timestamp, $this->password);

        if (strpos($date, '-') !== false) {
            $date = date('dmy', strtotime($date));
        }

        $paxXml = "";
        for ($i = 1; $i <= $paxCount; $i++) {
            $paxXml .= "<paxReference><ptc>ADT</ptc><traveller><ref>{$i}</ref></traveller></paxReference>";
        }

        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" 
    xmlns:wsa="http://www.w3.org/2005/08/addressing"
    xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"
    xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns:amasec="http://xml.amadeus.com/2010/06/Security_v1"
    xmlns:typ="http://xml.amadeus.com/FMPTBQ_24_6_1A">
   <soap:Header>
      <wsa:MessageID>urn:uuid:'.$messageId.'</wsa:MessageID>
      <wsa:Action>'.$soapAction.'</wsa:Action>
      <wsa:To>'.$this->endpoint.'</wsa:To>
      <wsse:Security>
         <wsse:UsernameToken wsu:Id="UsernameToken-1">
            <wsse:Username>'.$this->username.'</wsse:Username>
            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordDigest">'.$passwordDigest.'</wsse:Password>
            <wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">'.$nonce.'</wsse:Nonce>
            <wsu:Created>'.$timestamp.'</wsu:Created>
         </wsse:UsernameToken>
      </wsse:Security>
      <amasec:AMA_SecurityHostedUser>
         <amasec:UserID AgentDutyCode="SU" POS_Type="1" PseudoCityCode="'.$this->officeId.'" RequestorType="U"/>
      </amasec:AMA_SecurityHostedUser>
   </soap:Header>
   <soap:Body>
      <typ:Fare_MasterPricerTravelBoardSearch>
         <numberOfUnit>
            <unitNumberDetail>
               <numberOfUnits>'.$paxCount.'</numberOfUnits>
               <typeOfUnit>PX</typeOfUnit>
            </unitNumberDetail>
            <unitNumberDetail>
               <numberOfUnits>200</numberOfUnits>
               <typeOfUnit>RC</typeOfUnit>
            </unitNumberDetail>
         </numberOfUnit>
         '.$paxXml.'
         <fareOptions>
            <pricingTickInfo>
               <pricingTicketing>
                  <priceType>RP</priceType>
                  <priceType>RU</priceType>
                  <priceType>TAC</priceType>
               </pricingTicketing>
            </pricingTickInfo>
         </fareOptions>
         <itinerary>
            <requestedSegmentRef><segRef>1</segRef></requestedSegmentRef>
            <departureLocalization><departurePoint><locationId>'.$origin.'</locationId></departurePoint></departureLocalization>
            <arrivalLocalization><arrivalPointDetails><locationId>'.$destination.'</locationId></arrivalPointDetails></arrivalLocalization>
            <timeDetails><firstDateTimeDetail><date>'.$date.'</date></firstDateTimeDetail></timeDetails>
         </itinerary>
      </typ:Fare_MasterPricerTravelBoardSearch>
   </soap:Body>
</soap:Envelope>';

        $ch = curl_init($this->endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: text/xml; charset=utf-8",
            "SOAPAction: \"$soapAction\"",
            "Content-length: " . strlen($xmlRequest),
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Log::error('AmadeusSoapService: CURL Error: ' . $error);
            return ['error' => true, 'message' => 'CURL Error: ' . $error];
        }

        if ($httpCode >= 400) {
            Log::error('AmadeusSoapService: Request Failed', ['status' => $httpCode, 'body' => $response]);
            return ['error' => true, 'message' => 'Gateway Error: ' . $httpCode];
        }

        return $this->xmlToArray($response);
    }

    protected function xmlToArray($xml)
    {
        try {
            $cleanXml = str_ireplace(['soap:', 'soapenv:', 'typ:', 'amasec:', 'wsa:', 'wsse:', 'awsse:'], '', $xml);
            $xmlObj = simplexml_load_string($cleanXml);
            return json_decode(json_encode($xmlObj), true);
        } catch (\Exception $e) {
            return ['error' => true, 'message' => 'Failed to parse XML response'];
        }
    }
}
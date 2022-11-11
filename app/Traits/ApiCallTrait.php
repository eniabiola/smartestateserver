<?php


namespace App\Traits;


use App\Models\WebServiceTransactionLog;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

trait ApiCallTrait
{

    public  function curlPost($url, $data =[], $optionalHeaders = []){
//        return $url;
        $headers = [
            "Content-Type: application/json",
        ];

        if (! empty($optionalHeaders)) {
            $headers = array_merge($headers, $optionalHeaders);
        }

        /*print_r($url);
        echo "\n";
        print_r(array_values($headers));
        echo "\n";
        print_r($data);*/
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => $headers
        ));

        $response = curl_exec($curl);
        curl_close($curl);
/*        echo "response: \n";
        print_r($response);*/
//        return $response;
        return json_decode($response, true);
    }

    public function curlPost1($url, $data, $optionalHeaders = [])
    {
        $curl = curl_init();

        $headers = [
            "Content-Type: application/json",
        ];
        if (! empty($optionalHeaders)) {
            $headers = array_merge($headers, $optionalHeaders);
        }
        $data = json_encode($data);
        // $data = str_replace("\\", "", $data);
        logger($data);
        logger($url);

        $secret_key = config('flutterwave.secretKey');
     curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$data,
//            CURLOPT_HTTPHEADER => $headers,
             CURLOPT_HTTPHEADER => array(
                 "Content-Type: application/json",
                 "Authorization: Bearer ".$secret_key
         ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        logger($response);
        return json_decode($response, true);

    }

    public  function curlGet($url, array $queryData = [], $optionalHeaders = []){

        if (!empty($queryData) and count($queryData) > 0) {
            $queryString = http_build_query($queryData);
            $url = $url."?".$queryString;
        }

        $headers = [
            "Content-Type: application/json",
        ];

        if (! empty($optionalHeaders)) {
            $headers = array_merge($headers, $optionalHeaders);
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLINFO_HEADER_OUT => true,
            CURLOPT_VERBOSE => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }

    public function BearerToken()
    {
        if (Cache::has('bearer_token')){
            return Cache::get('bearer_token');
        }
        $url = config('constants.external_api_token_url').'/reset';
        $client_id = config('constants.client_id');
        $client_secret = config('constants.client_secret');


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'client_id='.$client_id.'&scope='.$client_id.'%2F.default&client_secret='.$client_secret.'&grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: citrix_ns_id=/rc4kw9xGa7j1jrUMIQtJoXAIuY0000; citrix_ns_id_.nibss-plc.com.ng_%2F_wat=AgAAAAUGJSkayw_y6cxHYEk2Rs80mR1oOW-dfvehjeqNvvjVaSJiW9xpocMALHWmLuVMaMtNxGGav0qwjsoOWWWwi0HSX0TwDi_nZri7_QZgpbD1yQ==&AgAAAAXmJVV1v6_3US0dSVzOot2ubq5tinVJGe7JeavxxJiisFamn9yf5QLM2eltXyZwv5hXKn1cLXvjkQfjvoysl2SFtpvTLJLcAtSgrHFUjIe4Tg==&; citrix_ns_id_.nibss-plc.com.ng_%2F_wlf=AgAAAAWr_w0JABja-xolJijnv02kyK5xCTweDv6YhMRnNQo-jw5h4M2WI4iAdVfkyDc9kNiMJSTMs2Drpd107XwVRMsf&; fpc=AnyiQBDgSdpJr0mk9pOlQa0vLErnAQAAALj8V9oOAAAA; stsservicecookie=estsfd; x-ms-gateway-slice=estsfd'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $decoded_response = json_decode($response, true);
        if (!is_null($decoded_response)) { Cache::put('bearer_token', $decoded_response, now()->addMinutes(54)); }

        return $decoded_response;
    }


    public function sendWebhook($sent_data)
    {
        $url = 'http://webhook.site/09f6054b-9460-4fac-b05c-01222b9a8779';
        $data = [
            'status_code' => 200,
            'status' => $sent_data['status'],
            'message' => $sent_data['message'],
            'data' => $sent_data['data']
        ];
        $json_array = json_encode($data);
        $curl = curl_init();
        $headers = ['Content-Type: application/json'];
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_array);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($http_code >= 200 && $http_code < 300) {
            echo "webhook send successfully.";
        } else {
            echo "webhook failed.";
        }
    }

    public function createXML($data)
    {
        $xml = new \DOMDocument( "1.0", "UTF-8" );

        // Create some elements.
        $xml_payment_status_response = $xml->createElement( "PaymentStatusResponse" );
        $xml_schedule = $xml->createElement( "ScheduleId", $data['schedule_id']);
        $xml_client_id = $xml->createElement( "ClientId", $data['client_id']);
        $xml_status = $xml->createElement( "Status", $data['status_code']);
        $xml_payment_records = $xml->createElement( "PaymentRecords");

        $xml_payment_status_response->appendChild($xml_schedule);
        $xml_payment_status_response->appendChild($xml_client_id);
        $xml_payment_status_response->appendChild($xml_status);

        //loop through data['payment_records'] create a parent record and attach to

                $xml_payment_record = $xml->createElement("PaymentRecord");
                $xml_payment_beneficiary = $xml->createElement("Beneficiary", $data["beneficiary"]);
                $xml_payment_amount = $xml->createElement("Amount", $data["amount"]);
                $xml_payment_account_number = $xml->createElement("AccountNumber", $data["account_number"]);
                $xml_payment_bank_code = $xml->createElement("BankCode", $data["bank_code"]);
                $xml_payment_narration = $xml->createElement("Narration", $data["narration"]);
                $xml_payment_serial_no = $xml->createElement("SerialNo", $data["serial_no"]);
                $xml_payment_status = $xml->createElement("Status", $data["status_code"]);
                $xml_payment_reason = $xml->createElement("Reason", $data["reason"]);

                $xml_payment_record->appendChild($xml_payment_beneficiary);
                $xml_payment_record->appendChild($xml_payment_amount);
                $xml_payment_record->appendChild($xml_payment_account_number);
                $xml_payment_record->appendChild($xml_payment_bank_code);
                $xml_payment_record->appendChild($xml_payment_narration);
                $xml_payment_record->appendChild($xml_payment_serial_no);
                $xml_payment_record->appendChild($xml_payment_status);
                $xml_payment_record->appendChild($xml_payment_reason);
                $xml_payment_records->appendChild($xml_payment_record);

        $xml_payment_status_response->appendChild($xml_payment_records);
        $xml->appendChild( $xml_payment_status_response );

// Parse the XML.
        $sending_xml = $xml->saveXML();

        $client = new Client();
        $create = $client->request('POST', 'https://css.ng/v1prod/css_api_v2_response', [
    //    $create = $client->request('POST', 'http://webhook.site/470a6605-acb6-47a9-8f46-9102ac399e20', [
            'headers' => [
                'Content-Type' => 'text/xml; charset=UTF8',
            ],
            'body' => $sending_xml
        ]);
    }
}

<?php

namespace Ipregistry\Laravel;
use Illuminate\Support\Facades\Facade;
class GetCurrentLocation extends Facade
{
    protected static function getFacadeAccessor() { return 'get_current_location'; }

    protected static function doAddition($numbers){
        return array_sum($numbers);
    }

    protected static function doMultiplication($numbers){
        return array_product($numbers);
    }

    protected static function getcurrentlocation($registrykey, $ipsaddresses = array(), $options = array()){
        $getipsaddresses = null;
        $getoptions = null;
        if(is_array($ipsaddresses) && count($ipsaddresses) > 0){
            $getipsaddresses = implode(',', $ipsaddresses);
        }
        if(is_array($options) && count($options) > 0){
            $getoptions .= "&fields=";
            foreach($options as $key => $value){
                $getoptions .= $key.'.'.$value;
            }
        }
        $url = 'https://api.ipregistry.co/'.$getipsaddresses.'?key='.$registrykey.$getoptions;
        $getcurrentlocationdetails = self::curlRequests($url, null, null, 'GET');
        return $getcurrentlocationdetails;
    }

    protected static function curlRequests($url, $headers, $data, $method)
    {
        $curloptions = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 70,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        );

        if (isset($headers) && (count($headers) > 0)) {
            $curloptions[CURLOPT_HTTPHEADER] = $headers;
        }
        if (isset($data) && (!empty($data))) {
            $curloptions[CURLOPT_POSTFIELDS] = json_encode($data);
        }
        $curl = curl_init();
        curl_setopt_array($curl, $curloptions);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            \Log::error('curl-error====>' . $err);
            return array("success" => false, 'message' => $err);
        } else {
            $response = json_decode($response);
            if (isset($response->error)) {
                \Log::error('api-error====>' . json_encode($response));
                return array("success" => false, 'message' => $response->error->message);
            } else {
                return array("success" => true, 'data' => $response);
            }
        }
    }
}
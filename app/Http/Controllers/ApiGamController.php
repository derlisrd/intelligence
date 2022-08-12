<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ApiGamController extends Controller
{
    public function SincronizarCampaigns(){

        $curl = curl_init();
        curl_setopt_array(
            $curl, [
            CURLOPT_URL => env('URL_END_POINT_GAM_API_CAMPAIGN'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"]
        );

            $response = curl_exec($curl);
            curl_close($curl);
            $values = (json_decode($response,true));
            print_r($values);
    }
}

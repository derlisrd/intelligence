<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConexionsController extends Controller
{

    public function conexions(){
        $breadcrumblinks = [
            [
                "active"=>true,
                "title"=>"Conexions",
                "route"=>null // name of the route
            ]
        ];
        return view('conexions.conexions',compact('breadcrumblinks'));
    }

    public function facebookcallback(){

        if(isset($_GET['code'])){
            $endpoint = "https://graph.facebook.com/".env('FB_API_VERSION')."/oauth/access_token";

            $code = $_GET['code'];
            $params = array(
                "client_id" => env("FB_APP_ID"),
                "client_secret" => env("FB_APP_SECRET"),
                "redirect_uri" => env("FB_APP_CALLBACK"),
                "code"=>$code,
                "fields"=>"email"
            );
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$endpoint.'?'.http_build_query($params));
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

            $fb = curl_exec($ch);
            $fbresponse = json_decode($fb,true);
            curl_close($ch);
            $fb_token = $fbresponse['access_token'];


            $endpointme = "https://graph.facebook.com/".env('FB_API_VERSION')."/me";
            $ch2 = curl_init();
            $params2 = array("fields"=>"email","access_token"=>$fb_token);

            curl_setopt($ch2,CURLOPT_URL,$endpointme.'?'.http_build_query($params2));
            curl_setopt($ch2,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch2,CURLOPT_SSL_VERIFYPEER, false);
            $fbme = curl_exec($ch2);
            curl_close($ch2);
             $fbresponse = json_decode($fbme,true);



            dd($fbresponse);



            //dd($fb_token);
        }
        //return view('conexions.facebookcallback',compact('fb_token'));
    }




    public function facebook(){

            $endpoint = "https://facebook.com/".env('FB_API_VERSION')."/dialog/oauth";
            $params = array(
                "client_id" => env("FB_APP_ID"),
                "redirect_uri" => env("FB_APP_CALLBACK"),
                "state" => env("FACEBOOK_APP_STATE"),
                "scope"=>"email,attribution_read,ads_management,ads_read,public_profile,read_insights"
            );

          $urllogin = $endpoint."?". http_build_query($params);

        $breadcrumblinks = [
            [
                "active"=>true,
                "title"=>"Conexions",
                "route"=>null // name of the route
            ]
        ];
        return view('conexions.facebook',compact('breadcrumblinks','urllogin'));
    }




    public function connect_facebook(){

    }


}

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
                "code"=>$code
            );
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$endpoint.'?'.http_build_query($params));
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

            $fb = curl_exec($ch);
            dd($fb);
            $fbresponse = json_decode($fb,true);
            curl_close($ch);
            $fb_token = $fbresponse['access_token'];


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

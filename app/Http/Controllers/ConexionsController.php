<?php

namespace App\Http\Controllers;

use App\Models\FacebookUser;
use Illuminate\Http\Request;

use FacebookAds\Object\User;
use FacebookAds\Object\Page;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;


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
            $params = [
                "client_id" => env("FB_APP_ID"),
                "client_secret" => env("FB_APP_SECRET"),
                "redirect_uri" => env("FB_APP_CALLBACK"),
                "code"=>$_GET['code']
            ];
            $endpoint = $endpoint.'?'.http_build_query($params);
            $fbresponse = json_decode(getcurl($endpoint),true);
            $access_token = $fbresponse['access_token'];

            $endpointme = "https://graph.facebook.com/".env('FB_API_VERSION')."/me?fields=email,id,name&access_token=$access_token";

            $fbresponse2 = json_decode(getcurl($endpointme),true);

            $email = $fbresponse2['email'];
            $facebook_user_id = $fbresponse2['id'];
            $name = $fbresponse2['name'];

            $Facebook  = new FacebookUser();
            $Facebook->email = $email;
            $Facebook->name = $name;
            $Facebook->facebook_user_id = $facebook_user_id;
            $Facebook->access_token = $access_token;
            $Facebook->save();
            $userfb = $Facebook::find($Facebook->id);

        }
        return view('conexions.facebookcallback',compact('userfb'));
    }

    public function ejemplo(){
        $token = $_GET['token'];
        $access_token = $token;
        $app_secret = env("FB_APP_SECRET");
        $app_id = env("FB_APP_ID");
        $iduser = $_GET['id'];
        //version v14.0
        $endpoint = "https://graph.facebook.com/".env("FB_API_VERSION")."/".$iduser."/adaccounts?access_token=$access_token";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$endpoint);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        $fbme = curl_exec($ch);
        curl_close($ch);
        print_r($fbme);
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

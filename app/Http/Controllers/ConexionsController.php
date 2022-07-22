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

        return view('conexions.facebookcallback');
    }




    public function facebook(){

            $endpoint = "https://facebook.com/".env('FB_API_VERSION')."/dialog/oauth";
            $params = array(
                "client_id" => env("FB_APP_ID"),
                "redirect_uri" => route("conexions.facebook.callback"),
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

<?php

namespace App\Http\Controllers;

use App\Models\FacebookUser;
use FacebookAds\Object\AdSet;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\CampaignFields;
use Illuminate\Http\Request;

class RelatoriosController extends Controller
{


    public function facebook(){

        $fbuser = new FacebookUser();
        $fbusers = $fbuser->all();
        $breadcrumblinks = [
            [
                "active"=>true,
                "title"=>"Facebook",
                "route"=>null// name of the route
            ]
        ];
        return view('containers.relatorios.facebook_lista',compact("fbusers","breadcrumblinks"));

    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Cotacao;
use App\Models\FacebookAdCampaign;
use App\Models\FacebookAdsAccount;
use App\Models\FacebookBusinessAccount;
use App\Models\FacebookLastCampaign;
use App\Models\FacebookUser;
use Illuminate\Http\Request;
use FacebookAds\Object\AdSet;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Fields\AdsInsightsFields;
use Laravel\Ui\Presets\React;



use FacebookAds\Object\AdCampaign;

class RelatoriosFacebookController extends Controller
{

    public function getFacebookusers(){
        $fbusers = FacebookUser::all();
        $breadcrumblinks = [
            [
                "active"=>false,
                "title"=>"Contas de facebook",
                "route"=>null // name of the route
            ],

        ];
        return view('containers.relatorios.facebook.users',compact("fbusers","breadcrumblinks"));
    }




    public function getCampaignsByAdAccountId (Request $request){


        $dolar = Cotacao::find(1)->first();
        $valordolarreal = $dolar->valor;

        $id = $request->user_fb_id;
        $fbuserid = $id;
        $fbuser = FacebookUser::find($id);
        $access_token = $fbuser->access_token;
        $breadcrumblinks = [
            [
                "active"=>false,
                "title"=>"Contas de facebook",
                "route"=>"relatorios.facebook.users" // name of the route
            ],
            [
                "active"=>true,
                "title"=>"Contas de anuncios",
                "route"=>null // name of the route
            ]
        ];

        $accounts = $fbuser->ads_accounts;
        $campaigns = [];
        /*
        foreach($accounts as $dato){
            $campanha = FacebookLastCampaign::where("account_id",$dato['account_id'])->get();
        } */


        return view('containers.relatorios.facebook.adaccounts',compact("fbuser","fbuserid",'breadcrumblinks','campaigns','valordolarreal'));

    }






}

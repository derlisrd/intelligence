<?php

namespace App\Http\Controllers;

use App\Models\Cotacao;
use App\Models\FacebookAdsAccount;
use App\Models\FacebookUser;
use Illuminate\Http\Request;

use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use App\Models\FacebookLastCampaign;
use App\Models\CountryCode;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdsInsights;

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


    public function viewCampaigns(Request $request){
        $paises = CountryCode::all();
        $breadcrumblinks = [];
        $fbuserid = $request->user_fb_id;
        $fbuser = FacebookUser::find($fbuserid);
        $accounts = $fbuser->ads_accounts;
        $campaigns = [];
        return view('containers.relatorios.facebook.campaigns',compact("fbuser","fbuserid",'breadcrumblinks','campaigns','paises'));
    }


    public function getCampaigns(Request $request){


        $paises = CountryCode::all();

        $fbuserid = $request->user_fb_id;
        $fbuser = FacebookUser::find($fbuserid);
        $account_id = $request->account_id;
        $until = $request->until;
        $to = $request->to;
        $country = $request->country;
        $last = FacebookLastCampaign::query();

        if($until && $to){
            $last->whereBetween("date_start", $until, $to);
        }
        if($account_id){
            $last->where("account_id", $account_id);
        }
        if($country){
            $last->where("country", $country);
        }

        $campaigns = $last->get();



        if(!$country){
            $arr = [];
            $impressions = 0;
            $spend = 0;
            $status  = 0;
            $clicks = 0;
            $cpm  = 0;

            $idcampaign = null;
            foreach($campaigns as $c){

                if($idcampaign == $c['campaign_id']){
                    $impressions +=  $c['impressions'];
                    $spend += $c['spend'];
                    $status  += $c['status'];
                    $clicks += $c['clicks'];
                    $cpm  += $c['cpm'];
                }
                else{
                    $impressions = $c['impressions'];
                    $spend = $c['spend'];
                    $status  = $c['status'];
                    $clicks = $c['clicks'];
                    $cpm  = $c['cpm'];
                }
                $idcampaign = $c['idcampaign'];

            }
        }



        $datas = [
            "fbuser"=>$fbuser,
            "campaigns"=>$campaigns,
            "paises"=>$paises,
            "fbuserid"=>$fbuserid,
            "country"=>$country,
            "account_id"=>$account_id
        ];



        return view('containers.relatorios.facebook.campaigns',$datas);
    }


    public function getCampaignsByAdAccountId (Request $request){

        $dolar = Cotacao::find(1)->first();
        $valordolarreal = $dolar->valor;
        $paises = CountryCode::all();

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
        return view('containers.relatorios.facebook.adaccounts',compact("fbuser","fbuserid",'breadcrumblinks','campaigns','valordolarreal','paises'));

    }




}

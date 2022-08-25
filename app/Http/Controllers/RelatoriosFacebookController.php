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
use App\Models\User;
use FacebookAds\Object\Ad;
use FacebookAds\Object\AdsInsights;
use Illuminate\Support\Facades\Auth;

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



    public function viewCampaign(){

        return view('containers.relatorios.facebook.campaign');
    }



    public function getLastCampaigns(){

        $id  = Auth::id();
        $user = User::find($id);
        $paises = CountryCode::all();
        $breadcrumblinks = [];
        $paises = CountryCode::all();
        $breadcrumblinks = [];
        $account_id = "";
        $accounts = [];
        $country = "";
        $campaigns = [];
        $fbuserid = 0;
        foreach($user->facebookusers as $fb){
            $fbuserid = $fb->id;
        }

        $fbuser = FacebookUser::find($fbuserid);
        if($fbuser->coun()>0){
            $accounts = ($fbuser->ads_accounts);
        };

        return view('containers.relatorios.facebook.campaigns',compact("country","account_id","fbuser","fbuserid",'breadcrumblinks','campaigns','paises'));
    }

    public function viewCampaigns(Request $request){
        $paises = CountryCode::all();
        $breadcrumblinks = [];
        $fbuserid = $request->user_fb_id;
        $fbuser = FacebookUser::find($fbuserid);
        $accounts = $fbuser->ads_accounts;
        $account_id = "";
        $country = "";
        $campaigns = [];
        return view('containers.relatorios.facebook.campaigns',compact("country","account_id","fbuser","fbuserid",'breadcrumblinks','campaigns','paises'));
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
            $last->whereBetween("date_start", $until." 00:00:01", $to." 23:59:59");
        }
        if($account_id){
            $last->where("account_id", $account_id);
        }
        if($country){
            $last->where("country", $country);
        }

        $campaigns = $last->get();



        $arr = [];
        if(!$country){
            $impressions = 0;
            $spend = 0;
            $clicks = 0;
            $cpm  = 0;
            $i = (-1);
            $idcampaign = null;
            foreach($campaigns as $c){
                if($idcampaign == $c['campaign_id']){
                    $impressions +=  $c['impressions'];
                    $spend += $c['spend'];
                    $clicks += $c['clicks'];
                    $cpm  += $c['cpm'];
                    $arr[$i] = array(
                        "campaign_name" => $c['campaign_name'],
                        "account_name"=>$c['account_name'],
                        "campaign_id" => $c['campaign_id'],
                        "impressions" => $impressions,
                        "spend" => $spend,
                        "status"=>$c['status'],
                        "country"=>"",
                        "clicks"=>$clicks,
                        "cpm"=>$cpm,
                        "cpc"=>"",
                        "date_start"=>$c['date_start'],
                    );
                }
                else{
                    $impressions = $c['impressions'];
                    $spend = $c['spend'];
                    $clicks = $c['clicks'];
                    $cpm  = $c['cpm'];
                    array_push($arr, array(
                        "campaign_name" => $c['campaign_name'],
                        "account_name"=>$c['account_name'],
                        "campaign_id" => $c['campaign_id'],
                        "impressions" => $impressions,
                        "spend" => $spend,
                        "status"=>$c['status'],
                        "country"=>"",
                        "clicks"=>$clicks,
                        "cpm"=>$cpm,
                        "cpc"=>"",
                        "date_start"=>$c['date_start'],
                    ));
                    $i++;
                }
                $idcampaign = $c['campaign_id'];

            }
        }

        if(count($arr)>0){
            $campaigns = $arr;
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

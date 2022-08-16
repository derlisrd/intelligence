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
        return view('containers.relatorios.facebook.adaccounts',compact("fbuser","fbuserid",'breadcrumblinks','campaigns','valordolarreal'));

    }




    public function last(){
        //$adaccounts = FacebookAdsAccount::all();
        $access_token = 'EAAKwf8KXPLgBACmXBjK7U7rPkFofKIZBHcWidebZA2tpsjK5n8MH04Gzpsc9BRzUHOvZAoEeRCfcyvrgVloTBnIZCrNDjCOSZAX44rvvm2wo8zwJ2c5QgE923x8qH8JIbznl5DaGZB5klEpHYYBM1F4tSyfZABX86VAVHwu3XNR7WFiw2ZCZCYB2goYHQmgNavQzQ0SJrdXxYZBqEjYeWEiB3RwqAcRtbX5cEoKMxjaLLNcAZDZD';

        $api = Api::init(env('FB_APP_ID'), env('FB_APP_SECRET'), $access_token);
        $api->setLogger(new CurlLogger());
        $id = "act_1112020715864027";
        $fields = ['targeting','country','campaign','name','objective','id','status','start_time','stop_time','account_id','special_ad_category_country','created_time','effective_status','source_campaign'];
        $params = ['effective_status' => ['ACTIVE'],'breakdowns'=>['country','targeting']];


        $c = (new AdAccount($id))
        ->getAdSets(['name','targeting{geo_locations{countries}}','campaign_id','start_time','stop_time','status','insights{cpm}'],
        //->getCampaigns(['name','targeting'],
        ["limit"=>200,'date_format' => 'Y-m-d H:i:s','breakdowns'=>['country']])
        ->getResponse()->getContent();


        $f = ['dda_results','reach','conversions','conversion_values','ad_id','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id'];

        echo "<pre>";

         foreach ($c['data'] as $v) {
            $countries = (new Campaign($v['campaign_id']))->getInsights($f,['breakdowns'=>['country'],"limit"=>200])
            ->getResponse()->getContent();

            foreach($countries['data'] as $b){
                $country = CountryCode::where('country_code',$b['country'])->get();
                                    $pais = $country->first();
                                    if($pais){
                                       $nomedopais = $pais->name;
                                    }

                echo $b['campaign_id']." ".$b['campaign_name']." => ".$nomedopais."<br />";
            }
        }
        echo "</pre>";
    }


}

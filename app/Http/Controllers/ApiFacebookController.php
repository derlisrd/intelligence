<?php

namespace App\Http\Controllers;

use App\Models\FacebookAdCampaign;
use App\Models\FacebookAdsAccount;
use App\Models\FacebookBusinessAccount;
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


class ApiFacebookController extends Controller
{

    // ACA TRAE LAS CAMPANHAS DE TODOS LAS CUENTAS
    public function getCampaigns(Request $request){
        $fbuserid = $request->fbuserid;
        $facebookuser = FacebookUser::find($fbuserid);
        $access_token = $facebookuser->access_token;
        $ads_accounts = $facebookuser->ads_accounts;
        $fields = ['name','objective','id','status','start_time','stop_time','account_id'];
        $params = array('effective_status' => array('ACTIVE','PAUSED'));
        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());
        $fields = ['name','objective','id','status','start_time','stop_time','account_id'];
        $params = array('effective_status' => array('ACTIVE','PAUSED'),);

        $campaigns = [];
        foreach($ads_accounts as $account){

            //$campaign = (new AdAccount($account['act_account_id']))->getCampaigns($fields,$params)->getResponse()->getContent();
            //$data = $campaign['data'];

            //count($data) > 0 ? array_push($campaigns,$data) : null;

        }
        //$campaign = (new AdAccount($act_id))->getCampaigns($fields,$params)->getResponse()->getContent();
        //$campaigns = $campaign['data'];


        return response()->json(["campaigns"=>$campaigns]);
    }














    public function getCampaignsByAdAccountId (Request $request){
        $fbuserid = $request->fbuserid;
        $fbuser = FacebookUser::find($fbuserid);
        $access_token = $fbuser->access_token;
        $act_id = "act_".$request->act_id;
        $campaigns = [];
        $insights = [];

        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');
        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());
        $fields = ['name','objective','id','status','start_time','stop_time','account_id'];
        $params = ['effective_status' => array('ACTIVE','PAUSED'),];
        $campaign = (new AdAccount($act_id))->getCampaigns($fields,$params)->getResponse()->getContent();
        $campaigns = $campaign['data'];

        $insightfields = ['ad_id','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id'];



        $insightparams = [];
        if(isset($_GET['since']) && isset($_GET['until'])){
            $since = $_GET['since']; $until = $_GET['until'];
            $insightparams = ['time_range'=>array('since'=>$since,'until'=>$until)];
        }



        foreach($campaigns as $field) {
            $datas = (new Campaign($field['id']))->getInsights($insightfields,$insightparams)->getResponse()->getContent();
            foreach($datas['data'] as $dato){
                array_push($insights,$dato);
            }

        }


        return response()->json(["insights"=>$insights]);
    }
















    public function apiCampaignsByAdAccountId (Request $request){

        $act_id = "act_".$request->act_id;
        $fbuserid = $request->fbuser_id;
        $fbuser = FacebookUser::find($fbuserid);
        $access_token = $fbuser->access_token;
        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = ['name','objective','id','status','start_time','stop_time','account_id'];
        $params = array('effective_status' => array('ACTIVE','PAUSED'));

        $campaign = (new AdAccount($act_id))->getCampaigns($fields,$params)->getResponse()->getContent();
        $campaigns = $campaign['data'];
        $adset = (new AdAccount($act_id))->getAdSets(['id','name','targeting','campaign_id'],[])->getResponse()->getContent();
        $adsets= $adset['data'];

        $insights = [];
        foreach($adsets as $a){
            $ads = (new AdSet($a['id']))->getInsights(['impressions'],[])->getResponse()->getContent();
             array_push($insights,$ads['data']);
        }

        $ad = (new AdAccount($act_id))->getAds(['id','name','campaign_id'],[])->getResponse()->getContent();
        $ads = $ad['data'];
        //return response()->json(["act"=>$act_id,"fbuser_id"=>$fbuserid,"token"=>$access_token,"campaigns"=>$campaigns]);




        return response()->json(["campaigns"=>$campaigns,"adsets"=>$adsets,"ads"=>$ads,"insights"=>$insights]);
    }
}

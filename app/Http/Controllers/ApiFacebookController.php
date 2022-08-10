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


    public function SincronizarCampaigns(){
        /* $users = FacebookUser::all();
        foreach($users as $user){
            $access_token = $user['access_token'];
            $facebook_user_id = $user['facebook_user_id'];
            $app_id = env('FB_APP_ID');
            $app_secret = env('FB_APP_SECRET');
            $api = Api::init($app_id, $app_secret, $access_token);
            $api->setLogger(new CurlLogger());
            $id = $user['id'];
            $accounts = FacebookAdsAccount::where("facebook_users_id",$id)->get();

            foreach($accounts as $account) {
                $act_id = $account['act_account_id'];
                $account_id = $account['account_id'];
                $fields = ['campaign','name','objective','id','status','start_time','stop_time','account_id','special_ad_category_country','created_time','effective_status','source_campaign'];
                $params = ['effective_status' => array('ACTIVE','PAUSED')];
                $campaign = (new AdAccount($act_id))->getCampaigns($fields,$params)->getResponse()->getContent();
                $campaigns = $campaign['data'];
                foreach($campaigns as $campaign) {
                    $idcampaign = $campaign['id'];
                    $insightfields = ['dda_results','reach','conversions','conversion_values','ad_id','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id'];

                    $insight = (new Campaign($idcampaign))->getInsights($insightfields,['date_preset' => 'maximum','breakdowns'=>['country']])->getResponse()->getContent();;
                    $dados = $insight['data'];
                    if(count($dados) > 0){
                        foreach($dados as $dato){
                            $last = FacebookLastCampaign::where('campaign_id', $idcampaign)->where('account_id', $account_id)->get();
                            $count = $last->count();
                            $datosnuevos = [
                                'account_currency' => $dato['account_currency'],
                                'account_name' => $dato['account_name'],
                                'account_id' => $dato['account_id'],
                                'campaign_id' => $dato['campaign_id'],
                                'campaign_name' => $dato['campaign_name'],
                                'clicks' => $dato['clicks'],
                                'cpc' => isset($dato['cpc']) ? $dato['cpc'] : null,
                                'cpm'=> $dato['cpm'],
                                'created_time' => $dato['created_time'],
                                'ctr' => $dato['ctr'],
                                'date_start' => $dato['date_start'],
                                'date_stop' => $dato['date_stop'],
                                'impressions' => $dato['impressions'],
                                'objective' => $dato['objective'],
                                'reach' => $dato['reach'],
                                'spend' => $dato['spend'],
                                'country' => $dato['country']
                            ];
                            if($count>0){
                                FacebookLastCampaign::where('campaign_id', $dato['campaign_id'])->where('account_id', $dato['account_id'])->update($datosnuevos);
                            }
                            else{
                                $save = new FacebookLastCampaign();
                                //FacebookLastCampaign::create($datosnuevos);
                                $save->account_currency = $dato['account_currency'];
                                $save->account_name = $dato['account_name'];
                                $save->account_id = $dato['account_id'];
                                $save->campaign_id = $dato['campaign_id'];
                                $save->campaign_name = $dato['campaign_name'];
                                $save->clicks = $dato['clicks'];
                                $save->cpc = isset($dato['cpc']) ? $dato['cpc'] : null;
                                $save->cpm = $dato['cpm'];
                                $save->created_time = $dato['created_time'];
                                $save->ctr = $dato['ctr'];
                                $save->date_start = $dato['date_start'];
                                $save->date_stop = $dato['date_stop'];
                                $save->impressions = $dato['impressions'];
                                $save->objective = $dato['objective'];
                                $save->reach = $dato['reach'];
                                $save->spend = $dato['spend'];
                                $save->country = $dato['country'];
                                $save->save();
                            }
                        }
                    }
                }
            }

        } */
    }




        public function SincronizarCampaignByAccountId(){


        }



    /* public function SincronizarCampaignByAccountId(Request $request){

        $fbuserid = $request->fbuserid;
        $fbuser = FacebookUser::find($fbuserid);
        $access_token = $fbuser->access_token;
        $act_id = "act_".$request->act_id;

        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');
        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());
        $fields = ['campaign','name','objective','id','status','start_time','stop_time','account_id','special_ad_category_country','created_time','effective_status','source_campaign'];
        $params = [
            'effective_status' => array('ACTIVE','PAUSED'),
            'time_range' => '{"since":"2022-08-01","until":"2022-08-04"}',
            'breakdowns'=>''
        ];
        $campaign = (new AdAccount($act_id))->getCampaigns($fields,$params)->getResponse()->getContent();
        $campaigns = $campaign['data'];


        $insightfields = ['dda_results','reach','conversions','conversion_values','ad_id','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id'];
        $insightparams = [];

        $insights = [];

        $campos = ['country','account_id','campaign_id','effective_status','name']; $parametros = ['breakdowns'=>array('country')];
        $getAds = (new AdAccount($act_id))->getAdSets($campos,$parametros)->getResponse()->getContent();
        echo "<pre>";
        foreach($campaigns as $campaign) {
            $id = $campaign['id'];
            $getAds = (new Campaign($id))->getAds(['targeting'],['breakdowns'=>['country']])->getResponse()->getContent();
            foreach($getAds['data'] as $value){
                print_r($value['targeting']['geo_locations']['countries']);
            }

        }
        echo "</pre>";


        return;
        foreach($campaigns as $campaign){
            $id = $campaign['id'];
            $account_id = $campaign['account_id'];
            $last = FacebookLastCampaign::where('campaign_id', $id)->where('account_id', $account_id)->get();
            $count = $last->count();
            $datas = (new Campaign($id))->getInsights($insightfields,$insightparams)->getResponse()->getContent();
            foreach($datas['data'] as $dato)
            {
                $datosnuevos = [
                    'account_currency' => $dato['account_currency'],
                    'account_name' => $dato['account_name'],
                    'account_id' => $dato['account_id'],
                    'campaign_id' => $dato['campaign_id'],
                    'campaign_name' => $dato['campaign_name'],
                    'clicks' => $dato['clicks'],
                    'cpc' => $dato['cpc'],
                    'cpm'=> $dato['cpm'],
                    'created_time' => $dato['created_time'],
                    'ctr' => $dato['ctr'],
                    'date_start' => $dato['date_start'],
                    'date_stop' => $dato['date_stop'],
                    'impressions' => $dato['impressions'],
                    'objective' => $dato['objective'],
                    'reach' => $dato['reach'],
                    'spend' => $dato['spend']
                ];
                if($count>0){
                    FacebookLastCampaign::where('campaign_id', $dato['campaign_id'])->where('account_id', $dato['account_id'])->update($datosnuevos);
                }
                else{
                    //FacebookLastCampaign::create($datosnuevos);
                    $save = new FacebookLastCampaign();
                    $save->account_currency = $dato['account_currency'];
                    $save->account_name = $dato['account_name'];
                    $save->account_id = $dato['account_id'];
                    $save->campaign_id = $dato['campaign_id'];
                    $save->campaign_name = $dato['campaign_name'];
                    $save->clicks = $dato['clicks'];
                    $save->cpc = $dato['cpc'];
                    $save->cpm = $dato['cpm'];
                    $save->created_time = $dato['created_time'];
                    $save->ctr = $dato['ctr'];
                    $save->date_start = $dato['date_start'];
                    $save->date_stop = $dato['date_stop'];
                    $save->impressions = $dato['impressions'];
                    $save->objective = $dato['objective'];
                    $save->reach = $dato['reach'];
                    $save->spend = $dato['spend'];
                    $save->save();
                }
                array_push($insights,$dato);
            }



        }


        return response()->json(["data"=>$insights]);
    } */





    public function getCampaignsByAdAccountId (Request $request){
        $fbuserid = $request->fbuserid;
        $fbuser = FacebookUser::find($fbuserid);
        $access_token = $fbuser->access_token;
        $act_id = "act_".$request->act_id;
        $campaigns = [];
        $insights = [];

        $LastCampaigns = FacebookLastCampaign::where("account_id", $request->act_id)->get();


        return response()->json(["data"=>$LastCampaigns]);
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



/*
        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');
        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());
        $fields = ['name','objective','id','status','start_time','stop_time','account_id'];
        $params = ['effective_status' => array('ACTIVE','PAUSED'),];
        $campaign = (new AdAccount($act_id))->getCampaigns($fields,$params)->getResponse()->getContent();
        $campaigns = $campaign['data'];

        $insightfields = ['reach','conversions','conversion_values','ad_id','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id'];
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










*/

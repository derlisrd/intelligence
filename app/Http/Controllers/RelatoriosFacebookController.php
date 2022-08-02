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


    public function storeCampaignByFacebookAdsAccount($id){
        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');

        $fbuser = FacebookUser::find($id);
        $access_token = $fbuser->access_token;

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $contas = $fbuser->ads_accounts ;

        foreach($contas as $conta) {
            $fields = ['name','objective','id'];
            $params = array('effective_status' => array('ACTIVE','PAUSED'));
            $datos = (new AdAccount($conta['act_account_id']))->getCampaigns($fields,$params)->getResponse()->getContent();
            $campaigns = [];
            if(count($datos['data'])>0){
                foreach($datos['data'] as $value){

                    $fbcampaign = new FacebookAdCampaign();
                    $fbcampaign->name = $value["name"];
                    $fbcampaign->objective = $value["objective"];
                    $fbcampaign->campaign_id = $value["id"];
                    $fbcampaign->facebook_ads_account_id = $conta['id'];
                    $fbcampaign->save();

                    $array = [
                        "campaign_id" => $value["id"],
                        "name" =>  $value["name"],
                        "objective" => $value["objective"],
                        "account_name" => $conta["name"]
                    ];
                    array_push($campaigns, $array);
                }

            }
            return $campaigns;

        }

    }


    public function getAdAccountsByUserId (Request $request){

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

        $fbcampaign = new FacebookAdCampaign();

        $fbcampaigns = $fbcampaign::all();
        $campaigns = [];
        if(count($fbcampaigns)===0){
           $campaigns = $this->storeCampaignByFacebookAdsAccount($id);
        }
        else{
            foreach($fbuser->ads_accounts as $value){
                $campanhas = FacebookAdCampaign::where(["facebook_ads_account_id"=>$value["id"]])->get();
                 foreach($campanhas as $campan){
                    $array = [
                        "campaign_id" => $campan->campaign_id,
                        "name" => $campan->name,
                        "objective" => $campan->objective,
                        "account_name" => $value["name"]
                    ];
                    array_push($campaigns, $array);
                 }
            }

        }




        return view('containers.relatorios.facebook.adaccounts',compact("fbuser","fbuserid",'breadcrumblinks','campaigns'));

    }





    public function getCampaignsByAdAccountId (Request $request){
        $act_id = "act_".$request->act_id;
        $fbuserid = $request->fbuser_id;
        $fbuser = FacebookUser::find($fbuserid);
        $datos_ads_account = FacebookAdsAccount::where(['facebook_users_id'=>$fbuser->id,"account_id"=>$request->act_id])->first();

        $access_token = $fbuser->access_token;
        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = ['name','objective','id'];
        $params = array('effective_status' => array('ACTIVE','PAUSED'));
        $datos = (new AdAccount($act_id))->getCampaigns($fields,$params)->getResponse()->getContent();

        $campaigns= $datos['data'];



        $breadcrumblinks = [
            [
                "active"=>false,
                "title"=>"Contas de facebook",
                "route"=>"relatorios.facebook.users" // name of the route
            ],
            [
                "active"=>false,
                "title"=>"Contas de anuncio ",
                "route"=>'relatorios.facebook.adaccounts',
                "routeparams"=>[$fbuserid]
            ],
            [
                "active"=>true,
                "title"=>"Campanhas",
                "route"=>null // name of the route
            ]
        ];



        return view ('containers.relatorios.facebook.campaigns',compact('campaigns','breadcrumblinks','datos_ads_account','fbuserid'));
    }





    public function getInsightsByIdCampaign(Request $request) {

        $fbuser_id = $request->fbuser_id;
        $campaign_id = $request->campaign_id;
        $fbuser = FacebookUser::find($fbuser_id);
        $access_token = $fbuser->access_token;
        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = ['impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id'];

        $params = [];
        $datas = (new Campaign($campaign_id))->getInsights($fields,$params)->getResponse()->getContent();

        $insights = $datas['data'];



        $breadcrumblinks = [
            [
                "active"=>false,
                "title"=>"Contas de facebook",
                "route"=>"relatorios.facebook.users" // name of the route
            ],
            [
                "active"=>false,
                "title"=>"Contas de anuncio ",
                "route"=>'relatorios.facebook.adaccounts',
                "routeparams"=>[$fbuser_id]
                /* "route"=> 'relatorios.facebook.campaigns', // name of the route
                "routeparams"=>[$fbuserid,$request->act_id] */
            ],
            [
                "active"=>false,
                "title"=>"Campanhas",
                "route"=>null
                //"route"=> 'relatorios.facebook.campaigns', // name of the route
                /* "routeparams"=>null */
            ],
            [
                "active"=>true,
                "title"=>"Visoes",
                "route"=>null // name of the route
            ]
        ];
        return view('containers.relatorios.facebook.insights',compact("insights",'breadcrumblinks'));


    }






    public function getCampaingById (Request $request){

        $id = $request->id;
        $user_id = $request->user_id;
        $user = new FacebookAdsAccount();
        $get_user = $user->find($user_id);
        $access_token = $get_user->facebook_user->access_token;
        //$ad_account_id = $get_user->act_account_id;


        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');


        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = array();
        $params = array(
        );
        echo json_encode((new Campaign($id))->getAds(
        $fields,
        $params
        )->getResponse()->getContent(), JSON_PRETTY_PRINT);


        /* $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = ['impressions','cpc','cpm','ctr','campaign_name','clicks'];
        $params = array('breakdown' => 'publisher_platform');
        $cursor = (new AdSet($id))->getInsights($fields,$params);
        $campaigns = [];
        foreach ($cursor as $campaign) {
            array_push($campaigns,
            array(
                "campaign_name"=>$campaign->{AdsInsightsFields::CAMPAIGN_NAME},
                "impressions"=>$campaign->{AdsInsightsFields::IMPRESSIONS},
                "cpm"=>$campaign->{AdsInsightsFields::CPM},
                "cpc"=>$campaign->{AdsInsightsFields::CPC},
                "clicks"=>$campaign->{AdsInsightsFields::CLICKS},
                "ctr"=>$campaign->{AdsInsightsFields::CTR},
            ));
        }
        $breadcrumblinks = [
            [
                "active"=>false,
                "title"=>"Campanhas de facebook",
                "route"=>"relatorios.facebook" // name of the route
            ],
            [
                "active"=>false,
                "title"=>"Campanha de facebook",
                "route"=>null // name of the route
            ]
        ];
        dd($campaigns); */
        //return view('containers.relatorios.facebook_campaign',compact("campaigns","breadcrumblinks"));
    }



    public function getCampaignsByAccountId(Request $request){


            $id = $request->id;
            $accounts = new FacebookAdsAccount();
            $accountget = $accounts::find($id);
            $act_account_id = $accountget->act_account_id;
            $access_token = $accountget->facebook_user->access_token;

            $app_id = env('FB_APP_ID');
            $app_secret = env('FB_APP_SECRET');

            $api = Api::init($app_id, $app_secret, $access_token);
            $api->setLogger(new CurlLogger());

            $fields = array(
            'objective','id','name','status','start_time','stop_time'
            );
            $params = array(
            'effective_status' => array('ACTIVE','PAUSED'),
            );

            $api = Api::init($app_id, $app_secret, $access_token);
            $api->setLogger(new CurlLogger());
            $account = new AdAccount($act_account_id);
            $cursor = $account->getCampaigns($fields,$params);


            $campaigns = [];
            foreach ($cursor as $campaign) {
                array_push($campaigns,
                array(
                    "id"=>$campaign->{CampaignFields::ID},
                    "name"=>$campaign->{CampaignFields::NAME},
                    "objective"=>$campaign->{CampaignFields::OBJECTIVE},
                    "status"=>$campaign->{CampaignFields::STATUS},
                    "start_time"=>date('Y-m-d H:i:s', strtotime($campaign->{CampaignFields::START_TIME})),
                    "end_time"=>date('Y-m-d H:i:s', strtotime($campaign->{CampaignFields::STOP_TIME}))
                ));
            }
            $breadcrumblinks = [
                [
                    "active"=>false,
                    "title"=>"Facebook",
                    "route"=>"relatorios.facebook" // name of the route
                ],
                [
                    "active"=>true,
                    "title"=>"Campanhas",
                    "route"=>null // name of the route
                ]
            ];

            $userid = $id;



        return view('containers.relatorios.facebook_campaigns_account',compact("campaigns","breadcrumblinks","userid"));



    }



    public function apiCampaignsByAdAccountIdJson (Request $request){

        $act_id = "act_".$request->act_id;
        $fbuserid = $request->fbuser_id;
        $fbuser = FacebookUser::find($fbuserid);


        $access_token = $fbuser->access_token;
        $app_id = env('FB_APP_ID');
        $app_secret = env('FB_APP_SECRET');

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = ['name','objective','id'];
        $params = array('effective_status' => array('ACTIVE','PAUSED'));
        $datos = (new AdAccount($act_id))->getCampaigns($fields,$params)->getResponse()->getContent();

        $campaigns= $datos['data'];

        return response()->json(["act"=>$act_id,"fbuser_id"=>$fbuserid,"token"=>$access_token,"campaigns"=>$campaigns]);

    }


}

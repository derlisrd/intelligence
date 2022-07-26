<?php

namespace App\Http\Controllers;

use App\Models\FacebookBussinessAccount;
use App\Models\FacebookUser;
use Illuminate\Http\Request;
use FacebookAds\Object\AdSet;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Fields\AdsInsightsFields;

class RelatoriosFacebookController extends Controller
{





    public function getBussinessAccountByUserId(Request $request){
        $id = $request->id;
        $fbusers = new FacebookBussinessAccount();
        $fb = $fbusers::where('facebook_users_id', $id)->get();

        if($fb->isEmpty()){
            $facebookusers = new FacebookUser();
            $facebookuser = $facebookusers::find($id);
            $facebook_user_id = $facebookuser->facebook_user_id;
            $access_token = $facebookuser->access_token;
            $endpoint = "https://graph.facebook.com/".env('FB_API_VERSION')."/".$facebook_user_id."/adaccounts?access_token=".$access_token;
            $response = json_decode(getcurl($endpoint),true);
            foreach($response['data'] as $value) {
                $fbinsert = new FacebookBussinessAccount();
                $fbinsert->facebook_users_id = $id;
                $fbinsert->account_id=$value['account_id'];
                $fbinsert->act_account_id=$value['id'];
                $fbinsert->save();
            }
        }

        $fbuser = new FacebookUser();
        $fbuser = $fbuser::find($id);
        $breadcrumblinks = [
            [
                "active"=>false,
                "title"=>"Facebook",
                "route"=>"relatorios.facebook" // name of the route
            ],
            [
                "active"=>true,
                "title"=>"Conta",
                "route"=>null // name of the route
            ]
        ];
        return view('containers.relatorios.facebook_bussiness_accounts',compact('fbuser','breadcrumblinks'));
    }





    public function getCampaingById (Request $request){

        $id = $request->id;
        $user_id = $request->user_id;
        $user = new FacebookBussinessAccount();
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
            $accounts = new FacebookBussinessAccount();
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





}

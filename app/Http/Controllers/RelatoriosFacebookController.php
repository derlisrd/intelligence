<?php

namespace App\Http\Controllers;

use App\Models\FacebookUser;
use Illuminate\Http\Request;
use FacebookAds\Object\AdSet;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Fields\AdsInsightsFields;

class RelatoriosFacebookController extends Controller
{


    public function getAcountsConnected(){

    }


    public function getCampainByUserId(Request $request){
        $id = $request->id;
        $fbusers = new FacebookUser();

        $fbuser = $fbusers::find($id);
        $facebook_user_id = $fbuser->facebook_user_id;
        $access_token = $fbuser->access_token;
        $endpoint = "https://graph.facebook.com/".env('FB_API_VERSION')."/".$facebook_user_id."/adaccounts?access_token=".$access_token;

        $response = json_decode(getcurl($endpoint),true);




        dd($response);

    }


    public function getCampaign(Request $request){


        $id = $request->id_campaign;

            $app_id = env('FB_APP_ID');
            $app_secret = env('FB_APP_SECRET');
            $api_version = env('FB_API_VERSION');
            $access_token = env('FB_ACCESS_TOKEN');
            $ad_account_id = "act_243085842410522";

        $api = Api::init($app_id, $app_secret, $access_token);
        $api->setLogger(new CurlLogger());

        $fields = array(
        'impressions','cpc','cpm','ctr','campaign_name','clicks'
        );
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

        return view('containers.relatorios.facebook_campaign',compact("campaigns","breadcrumblinks"));

    }





}

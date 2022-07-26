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



    public function facebook_(){



            $app_id = env('FB_APP_ID');
            $app_secret = env('FB_APP_SECRET');
            $api_version = env('FB_API_VERSION');
            $access_token = env('FB_ACCESS_TOKEN');
            $ad_account_id = "act_243085842410522";


            /* $api = Api::init($app_id, $app_secret, $access_token);
            $api->setLogger(new CurlLogger());

            $fields = array(
            'impressions',
            );
            $params = array(
            'breakdown' => 'publisher_platform',
            );
            echo json_encode((new AdSet($ad_account_id))->getInsights(
            $fields,
            $params
            )->getResponse()->getContent(), JSON_PRETTY_PRINT);


            // Initialize a new Session and instantiate an Api object
            Api::init($app_id, $app_secret, $access_token);

            // The Api object is now available through singleton
            $api = Api::instance();
            $account = new AdAccount($ad_account_id);
            $cursor = $account->getCampaigns(['id','name','status','start_time','end_time']);


            // Loop over objects
            foreach ($cursor as $campaign) {
            echo $campaign->{CampaignFields::NAME}.PHP_EOL."- STATUS ". $campaign->{CampaignFields::STATUS}."- START_TIME: ". $campaign->{CampaignFields::START_TIME}."<br />";
            }

            // Access objects by index
            if ($cursor->count() > 0) {
            echo "The first campaign in the cursor is: ".$cursor[0]->{CampaignFields::NAME}.PHP_EOL;
            }
            //$pila = array("naranja", "plátano");
            //array_push($pila, "manzana", "arándano");
            // Fetch the next page
            $cursor->fetchAfter(); */

            Api::init($app_id, $app_secret, $access_token);

            // The Api object is now available through singleton
            //$api = Api::instance();
            $account = new AdAccount($ad_account_id);
            $cursor = $account->getCampaigns(['id','name','status','start_time','stop_time']);
            $campaigns = [];
            foreach ($cursor as $campaign) {
                array_push($campaigns,
                array(
                    "id"=>$campaign->{CampaignFields::ID},
                    "name"=>$campaign->{CampaignFields::NAME},
                    "status"=>$campaign->{CampaignFields::STATUS},
                    "start_time"=>date('Y-m-d H:i:s', strtotime($campaign->{CampaignFields::START_TIME})),
                    "end_time"=>date('Y-m-d H:i:s', strtotime($campaign->{CampaignFields::STOP_TIME}))
                ));
            }
            $breadcrumblinks = [
                [
                    "active"=>true,
                    "title"=>"Campanhas de facebook",
                    "route"=>"relatorios.facebook" // name of the route
                ]
            ];

        return view('containers.relatorios.facebook',compact("campaigns","breadcrumblinks"));
    }
}

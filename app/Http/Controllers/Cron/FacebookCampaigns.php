<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\FacebookAdsAccount;
use App\Models\FacebookUser;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use Illuminate\Http\Request;

class FacebookCampaigns extends Controller
{





    public function getcampaigns()
    {
        $users = FacebookUser::all();

        foreach($users as $user){

            $access_token = $user['access_token'];

            $api = Api::init(env('FB_APP_ID'), env('FB_APP_SECRET'), $access_token);
            $api->setLogger(new CurlLogger());

            $act_id = 'act_170709447283865';
            $idcampaign = '23851453481370712';
            /* $c = (new AdAccount($act_id))
               ->getCampaigns(['id','name','status','start_time','stop_time','account_id','targeting','account_name'],
               ["limit"=>200,'date_format' => 'Y-m-d H:i:s','breakdowns'=>['country'],'date_preset'=>'today'])
               ->getResponse()->getContent();

            echo '<pre>';
               print_r($c['data']);
               echo '</pre>'; */
               $date = date('Y-m-d');
               $f = ['website_ctr','cost_per_conversion','actions','ad_click_actions','dda_results','conversions','reach','conversions','conversion_values','ad_id','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id','objective'];
               $b = ['breakdowns'=>['country'],"limit"=>200,'date_format' => 'Y-m-d H:i:s','date_preset'=>'today','time_range'=>['since'=>"$date",'until'=>"$date"]];

            $i = (new Campaign($idcampaign))->getInsights($f,$b)->getResponse()->getContent();

            echo '<pre>';
               print_r($i);
            echo '</pre>';

        }



    }




}

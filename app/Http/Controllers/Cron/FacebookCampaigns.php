<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\CountryCode;
use App\Models\FacebookAdsAccount;
use App\Models\FacebookLastCampaign;
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
            $idcampaign = '23850480526260712';
            /* $c = (new AdAccount($act_id))
               ->getCampaigns(['id','name','status','start_time','stop_time','account_id','targeting','account_name'],
               ["limit"=>200,'date_format' => 'Y-m-d H:i:s','breakdowns'=>['country'],'date_preset'=>'today'])
               ->getResponse()->getContent();

            echo '<pre>';
               print_r($c['data']);
               echo '</pre>'; */
               //$date = date('Y-m-d');
               $date = "2022-08-30";
               //'website_ctr','actions',
               $f = ['actions','action_values{action_type}','conversions','reach','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id','objective'];
               $b = ['level'=>'campaign','breakdowns'=>['country'],"limit"=>200,'date_format' => 'Y-m-d H:i:s','date_preset'=>'today','time_range'=>['since'=>"$date",'until'=>"$date"]];

            $dato = (new Campaign($idcampaign))->getInsights($f,$b)->getResponse()->getContent();

           /*  $landing_page_view = isset($dato['data'][1]['actions'][0]['value']) ? $dato['data'][1]['actions'][0]['value'] : null;
            $web_content_view = isset($dato['data'][1]['actions'][1]['value']) ? $dato['data'][1]['actions'][1]['value'] : null;
            $view_content = isset($dato['data'][1]['actions'][2]['value']) ? $dato['data'][1]['actions'][2]['value'] : null;*/
            echo '<pre>';
                if(count(($dato['data']))>0){
                    print_r($dato['data']);
                }

            echo '</pre>';

        }



    }


    public function face()
    {
        $users = FacebookUser::all();
        $datetoday = date('Y-m-d');
        foreach($users as $user){

            $access_token = $user['access_token'];
            $api = Api::init(env('FB_APP_ID'), env('FB_APP_SECRET'), $access_token);
            $api->setLogger(new CurlLogger());
            $id = $user['id'];
            $accounts = FacebookAdsAccount::where([["facebook_users_id",'=',$id],['account_active','=',1]])->get();


                $act_id = 'act_386871958696671';
                //$account_id = $account['account_id'];
                //$account_name = $account['account_name'];

                $c = (new AdAccount($act_id))
               ->getCampaigns(['id','name','status','start_time','stop_time','account_id','targeting','account_name'],
               ["limit"=>200,'date_format' => 'Y-m-d H:i:s','breakdowns'=>['country'],'date_preset'=>'last_90d'])
               ->getResponse()->getContent();

                $campaign = $c['data'];

                $date = "2022-08-30";
                $f = ['actions','action_values'=>['offsite_conversion.fb_pixel_view_content'],'conversions','reach','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id','objective'];
                $b = ['level'=>'campaign','breakdowns'=>['country'],"limit"=>200,'date_format' => 'Y-m-d H:i:s','date_preset'=>'today','time_range'=>['since'=>"$date",'until'=>"$date"]];

                print "<pre>";
                if(count($campaign) > 0){
                    foreach($campaign as $v){
                        $status = $v['status'];
                        $campaign_name = $v['name'];
                        $idcampaign = $v['id'];
                        //$idcampaign = $v['campaign_id'];
                        $campana = [];
                        $dato = (new Campaign("23850480526260712"))->getInsights($f,$b)->getResponse()->getContent();
                        print_r($dato);
                    }
                }
                print "</pre>";

        }
    }



}

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





    public function fb()
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


    public function outro()
    {
        $users = FacebookUser::all();
        $datetoday = date('Y-m-d');
        foreach($users as $user){

            $access_token = $user['access_token'];
            $api = Api::init(env('FB_APP_ID'), env('FB_APP_SECRET'), $access_token);
            $api->setLogger(new CurlLogger());
            $id = $user['id'];
            //$accounts = FacebookAdsAccount::where([["facebook_users_id",'=',$id],['account_active','=',1]])->get();


                $act_id = 'act_386871958696671';
                //$account_id = $account['account_id'];
                //$account_name = $account['account_name'];

                $c = (new AdAccount($act_id))
               ->getCampaigns(['id','name','status','start_time','stop_time','account_id','targeting','account_name'],
               ["limit"=>200,'date_format' => 'Y-m-d H:i:s','breakdowns'=>['country'],'date_preset'=>'last_90d'])
               ->getResponse()->getContent();

                $campaign = $c['data'];

                $date = "2022-08-30";
                $f = ['actions','conversions','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id','objective'];
                $b = ['action_breakdowns'=>"action_type",'level'=>'campaign','breakdowns'=>['country'],"limit"=>200,'date_format' => 'Y-m-d H:i:s','date_preset'=>'today','time_range'=>['since'=>"$date",'until'=>"$date"]];

                print "<pre>";
                if(count($campaign) > 0){
                    foreach($campaign as $v){
                        $idcampaign = $v['id'];
                        $dato = (new Campaign($idcampaign))->getInsights($f,$b)->getResponse()->getContent();
                       if(count($dato["data"])>0){
                        print_r($dato["data"]);
                       }
                    }
                }
                print "</pre>";

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


            //foreach($accounts as $account) {
                print "<pre>";
                foreach([0] as $account) {
                //$act_id = $account['act_account_id'];
                $act_id = "act_386871958696671";
                //$account_id = $account['account_id'];
                //$account_name = $account['account_name'];

                $c = (new AdAccount($act_id))
               ->getCampaigns(['id','name','status','start_time','stop_time','account_id','targeting','account_name'],
               ["limit"=>200,'date_format' => 'Y-m-d H:i:s','breakdowns'=>['country'],'date_preset'=>'last_30d'])
               ->getResponse()->getContent();

                $campaign = $c['data'];

                //$date = date('Y-m-d');
                $date = "2022-08-30";
                //'actions','action_values{value}',
                $f = ['actions','conversions','reach','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id','objective'];
                $b = ['level'=>'campaign','breakdowns'=>['country'],"limit"=>200,'date_format' => 'Y-m-d H:i:s','date_preset'=>'today','time_range'=>['since'=>"$date",'until'=>"$date"]];


                if(count($campaign) > 0){
                     foreach($campaign as $v){
                        $status = $v['status'];
                        $campaign_name = $v['name'];
                        $idcampaign = $v['id'];
                        //$idcampaign = $v['campaign_id'];
                        $insight = (new Campaign($idcampaign))->getInsights($f,$b)->getResponse()->getContent();
                        $dados = $insight['data'];

                         if(count($dados) > 0){
                            foreach($dados as $dato){
                                $nomedopais = null;
                                //print_r($dato);
                                if(isset($dato['country'])) {
                                    $country_code = CountryCode::where('country_code',$dato['country'])->get();
                                    $country = $country_code->first();
                                    if($country){
                                    $nomedopais = $country->name;
                                    }
                                }


                                $last = FacebookLastCampaign::
                                where([
                                    ['country', '=', $nomedopais],
                                    ['campaign_id', '=', $idcampaign],
                                    ['date_preset', '=', $datetoday]
                                ])
                                ->get();
                                $count = $last->count();
                                $landing_page_view = null;
                                $fb_pixel_view_content = null;
                                $view_content = null;




                                if(isset($dato['actions']) ) {
                                    foreach ($dato['actions'] as $action) {
                                        if($action['action_type']=='landing_page_view'){
                                            $landing_page_view = $action['value'];
                                        }
                                        if($action['action_type']=='offsite_conversion.fb_pixel_view_content'){
                                            $fb_pixel_view_content = $action['value'];
                                        }
                                        if($action['action_type']=='view_content'){
                                            $view_content = $action['value'];
                                        }
                                    }
                                }
                                echo $dato['country']. "---";
                                echo $dato['campaign_id'] . "=>";
                                echo "fbpixel: ". $fb_pixel_view_content ."<br>";

                                /* $datosnuevos = [
                                    "landing_page_view"=>$landing_page_view,
                                    "fb_pixel_view_content"=>$fb_pixel_view_content,
                                    "view_content"=>$view_content,
                                    'account_currency' => $dato['account_currency'],
                                    'account_name' => $dato['account_name'],
                                    'account_id' => $dato['account_id'],
                                    'campaign_id' => $dato['campaign_id'],
                                    'campaign_name' => $campaign_name,
                                    'clicks' => $dato['clicks'],
                                    'cpc' => isset($dato['cpc']) ? $dato['cpc'] : null,
                                    'cpm'=> $dato['cpm'],
                                    'created_time' => $dato['created_time'],
                                    'ctr' => $dato['ctr'],
                                    'date_preset' => $dato['date_start'],
                                    'date_start' => $dato['date_start'],
                                    'date_stop' => $dato['date_stop'],
                                    'impressions' => $dato['impressions'],
                                    'objective' => $dato['objective'],
                                    'reach' => $dato['reach'],
                                    'spend' => $dato['spend'],
                                    'country' =>$nomedopais,
                                    'status'=>$status
                                ]; */
                                /* if($count>0){
                                    $get = $last->first();
                                    $id = $get->id;
                                    //echo "<br> UPDATE O ID =".$idcampaign . " PAIS=".$nomedopais;
                                    FacebookLastCampaign::where('id',$id)->update($datosnuevos);
                                }
                                else{
                                    FacebookLastCampaign::create($datosnuevos);

                                    //echo "<br> NOVO INSERT O ID =".$idcampaign. " PAIS=".$nomedopais;;
                                } */
                            }
                        }
                    }
                }
            }
            print "</pre>";
        }
    }



}

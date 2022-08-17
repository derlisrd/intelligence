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
        $users = FacebookUser::all();
        foreach($users as $user){
            $access_token = $user['access_token'];
            $api = Api::init(env('FB_APP_ID'), env('FB_APP_SECRET'), $access_token);
            $api->setLogger(new CurlLogger());
            $id = $user['id'];
            $accounts = FacebookAdsAccount::where("facebook_users_id",$id)->get();
            foreach($accounts as $account) {
                $act_id = $account['act_account_id'];
                $account_id = $account['account_id'];
                $account_name = $account['account_name'];
                $c = (new AdAccount($act_id))
                ->getAdSets(['targeting{geo_locations{countries}}','name','objective','id','status','start_time','stop_time','account_id','special_ad_category_country','created_time','effective_status','source_campaign','account_name'],
                ["limit"=>200,'date_format' => 'Y-m-d H:i:s','breakdowns'=>['country'],'effective_status' => array('ACTIVE','PAUSED')])
                ->getResponse()->getContent();



                $campaign = $c['data'];


                echo "<pre>";
                $f = ['dda_results','reach','conversions','conversion_values','ad_id','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id'];
                $b = ['breakdowns'=>['country'],"limit"=>200];
                if(count($campaign) > 0){
                    foreach($campaign as $v){
                        print_r($v);
                        $status = $v['status'];
                        $campaign_name = $v['name'];
                        $idcampaign = $v['id'];
                        $insight = (new Campaign($idcampaign))->getInsights($f,$b)->getResponse()->getContent();
                        $dados = $insight['data'];

                        if(count($dados) > 0){
                            foreach($dados as $dato){
                                $nomedopais = null;
                                if(isset($dato['country'])) {
                                    $consultapais = $dato['country'];
                                }



                                $last = FacebookLastCampaign::where('campaign_id', $idcampaign)
                                ->where('account_id', $account_id)
                                ->where('country', $nomedopais)
                                ->get();
                                $count = $last->count();


                                $datosnuevos = [
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
                                    'date_start' => $dato['date_start'],
                                    'date_stop' => $dato['date_stop'],
                                    'impressions' => $dato['impressions'],
                                    'objective' => $dato['objective'],
                                    'reach' => $dato['reach'],
                                    'spend' => $dato['spend'],
                                    'country' =>$nomedopais,
                                    'status'=>$status
                                ];
                                if($count>0){
                                    $get = $last->first();
                                    $id = $get->id;
                                    FacebookLastCampaign::where('id',$id)->update($datosnuevos);
                                }
                                else{
                                    FacebookLastCampaign::create($datosnuevos);
                                }
                            }
                        }
                    }
                }
                echo "</pre>";
            }
        }
    }


}

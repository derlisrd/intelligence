<?php

namespace App\Console\Commands;

use App\Models\CountryCode;
use App\Models\FacebookAdsAccount;
use App\Models\FacebookUser;
use Illuminate\Console\Command;
use App\Models\FacebookLastCampaign;
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;



class CronCampanhas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getcampaigns:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */





    public function handle()
    {
        $users = FacebookUser::all();

        foreach($users as $user){

            $access_token = $user['access_token'];
            $api = Api::init(env('FB_APP_ID'), env('FB_APP_SECRET'), $access_token);
            $api->setLogger(new CurlLogger());
            $id = $user['id'];
            $accounts = FacebookAdsAccount::where("facebook_users_id",$id)->get();


            foreach($accounts as $account) {
                $act_id = $account['act_account_id'];
                //$account_id = $account['account_id'];
                //$account_name = $account['account_name'];

                $c = (new AdAccount($act_id))
               ->getCampaigns(['id','name','status','start_time','stop_time','account_id','targeting','account_name'],
               ["limit"=>200,'date_format' => 'Y-m-d H:i:s','breakdowns'=>['country'],'date_preset'=>'last_90d'])
               ->getResponse()->getContent();

                $campaign = $c['data'];

                $f = ['dda_results','reach','conversions','conversion_values','ad_id','objective','created_time','impressions','cpc','cpm','ctr','campaign_name','clicks','spend','account_currency','account_id','account_name','campaign_id'];
                $b = ['breakdowns'=>['country'],"limit"=>200,'date_format' => 'Y-m-d H:i:s'];



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

                                print_r($dato);

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
                                    ['campaign_id', '=', $idcampaign]
                                ])
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
                                    //echo "<br> UPDATE O ID =".$idcampaign . " PAIS=".$nomedopais;
                                    FacebookLastCampaign::where('id',$id)->update($datosnuevos);
                                }
                                else{
                                    FacebookLastCampaign::create($datosnuevos);
                                    //echo "<br> NOVO INSERT O ID =".$idcampaign. " PAIS=".$nomedopais;;
                                }
                            }
                        }
                    }
                }

            }
        }



    }




}

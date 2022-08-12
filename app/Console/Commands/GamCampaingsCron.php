<?php

namespace App\Console\Commands;

use App\Models\GoogleGamCampaigns;
use Illuminate\Console\Command;

class GamCampaingsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamcampains:cron';

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
        $curl = curl_init();
        curl_setopt_array(
            $curl, [
            CURLOPT_URL => env('URL_END_POINT_GAM_API_CAMPAIGN'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"]
        );

            $response = curl_exec($curl);
            curl_close($curl);
            $values = (json_decode($response,true));
            foreach($values as $value){
                $datosnuevos = [
                    "date"=>$value['DATE'],
                    "domain"=>$value['DOMAIN'],
                    "country"=>$value['COUNTRY'],
                    "name"=>$value['CUSTOM_CRITERIA_NAME'],
                    "value"=>$value['CUSTOM_CRITERIA_VALUE'],
                    "impressions"=>$value['AD_EXCHANGE_LINE_ITEM_LEVEL_IMPRESSIONS'],
                    "clicks"=>$value['AD_EXCHANGE_LINE_ITEM_LEVEL_CLICKS'],
                    "ctr"=>$value['AD_EXCHANGE_LINE_ITEM_LEVEL_CTR'],
                    "receita"=>$value['AD_EXCHANGE_LINE_ITEM_LEVEL_REVENUE'],
                    "cpm"=>$value['AD_EXCHANGE_LINE_ITEM_LEVEL_AVERAGE_ECPM'],
                    "impressions_rate"=>$value['AD_EXCHANGE_ACTIVE_VIEW_VIEWABLE_IMPRESSIONS_RATE'],
                ];

                $last = GoogleGamCampaigns::where('domain', $value['DOMAIN'])
                ->where('name', $value['CUSTOM_CRITERIA_NAME'])
                ->where('value', $value['CUSTOM_CRITERIA_VALUE'])
                ->where('country', $value['COUNTRY'])
                ->get();
                $count = $last->count();


                if($count>0){
                    $get = $last->first();
                    $id = $get->id;
                    GoogleGamCampaigns::where('id',$id)->update($datosnuevos);
                }
                else{
                    GoogleGamCampaigns::create($datosnuevos);
                }


            }
    }
}

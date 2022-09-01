<?php

namespace App\Http\Controllers;

use App\Models\Cotacao;
use App\Models\CountryCode;
use App\Models\Domain;
use App\Models\FacebookLastCampaign;
use App\Models\GoogleGamCampaigns;
use Illuminate\Http\Request;

class ReceitasController extends Controller
{


    public function index(){
        $dolar = Cotacao::find(1);
        $dolar = $dolar->valor;
        $data = [
            "domains"=>Domain::orderBy('domain')->get(),"campaigns"=>[],
            "countries"=>CountryCode::all()->sortBy("name"),
            "domain"=>"",
            "country"=>"",
            "value"=>"",
            "dolar"=>$dolar,
            "reports"=>[],
        ];

        return view('containers.relatorios.receitas.campanhas',$data);
    }


    public function campaigns(Request $request){

        $dolar = Cotacao::find(1);
        $dolar = $dolar->valor;
        $datetoday = date('Y-m-d');
        $flc = FacebookLastCampaign::query();

        $domain = $request->domain;
        $country = $request->country;
        $value = $request->value;

        $desde = $request->desde;
        $hasta = $request->hasta;

        if($domain){
            $flc->where('campaign_name','LIKE','%'.$domain.'%');
        }
        if($country){
            $flc->where('country','=',$country);
        }
        if($value){
            $flc->where('campaign_name','LIKE','%'.$value.'%');
        }

        if($desde && $hasta){
            $flc->whereBetween('date_preset',[$desde,$hasta]);
        }
        else{
            $flc->where('date_preset',$datetoday);
        }

        $facebook = $flc->get();

        $report = [];


        /*  echo "<pre>"; */
        foreach($facebook as $fb){
            $keyvalue = $fb['campaign_name'];
            $pais = $fb['country'];
            $date_preset = $fb['date_preset'];
            $arr = explode('#',$keyvalue);

            if(!$domain){
                $domain = $arr[0];
            }
            $val = $arr[1];
             $gam = GoogleGamCampaigns::where([
                ["domain","=",$domain],
                ["name","=",'utm_campaign'],
                ["value","=",$val],
                ["country","=",$pais],
                ["date","=",$date_preset]
                ])->get();
            $count = $gam->count();
            $google = ($gam->first());

            if($count>0){
                $narray= [
                    "impressions_fb"=>$fb['impressions'],
                    "clicks_fb"=>$fb['clicks'],
                    "ctr_fb"=>$fb['ctr'],
                    "cpm_fb"=>$fb['cpm'],
                    "cpc_fb"=>$fb['cpc'],
                    "campaign_name"=>$fb['campaign_name'],
                    "account_name"=>$fb['account_name'],
                    "objective"=>$fb['objective'],
                    "spend"=> $fb['spend'],
                    "fb_pixel_view_content"=>$fb["fb_pixel_view_content"],

                    "date"=>$google->date,
                    "clicks"=>$google->clicks,
                    "domain"=>$google->domain,
                    "cpm"=>$google->cpm,
                    "ctr"=>$google->ctr,
                    "receita"=>$google->receita,
                    "impressions"=>$google->impressions,
                    "key_value"=>$google->value,
                    "country"=>$google->country
                ];
                array_push($report,$narray);
            }

        }

        /*  echo "</pre>";
        return; */


        $data = [
            "domains"=>Domain::orderBy('domain')->get(),"campaigns"=>[],
            "countries"=>CountryCode::all()->sortBy("name"),
            "domain"=>$domain,
            "country"=>$country,
            "value"=>$value,
            "reports"=>$report,
            "dolar"=>$dolar,
            "desde"=>$desde,
            "hasta"=>$hasta
        ];



        return view('containers.relatorios.receitas.campanhas',$data);
    }

}

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
        $fbc = FacebookLastCampaign::query();

        $domain = $request->domain;
        $country = $request->country;
        $value = $request->value;

        $desde = $request->desde;
        $hasta = $request->hasta;

        if($domain){
            $fbc->where('campaign_name','LIKE','%'.$domain.'%');
        }
        if($country){
            $fbc->where('country','=',$country);
        }
        if($value){
            $fbc->where('campaign_name','LIKE','%'.$value.'%');
        }

        if($desde && $hasta){
            $fbc->whereBetween('date_preset',[$desde,$hasta]);
        }
        else{
            $fbc->where('date_preset',$datetoday);
        }



        $facebook = ($fbc->get()->toArray());
        $report = [];
        //echo "<pre>";
        foreach($facebook as $row){
            $keyvalue = $row['campaign_name'];
            $pais = $row['country'];
            $date_preset = $row['date_preset'];
            $arr = explode('#',$keyvalue);
            $custodolar = $row['spend'] / $dolar;

            //preg_match_all('!\d+!', $arr[1], $matches);
            //$valuefb = ($matches[0][0]);
            //["value","LIKE",'%'.$valuefb.'%'],
            $val = $arr[1];
            //print($arr[0]) ; echo   ."<br>";
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
                    "date"=>$google->date,
                    "impressions_fb"=>$row['impressions'],
                    "clicks_fb"=>$row['clicks'],
                    "ctr_fb"=>$row['ctr'],
                    "cpc_fb"=>$row['cpc'],
                    "campaign_name"=>$row['campaign_name'],
                    "account_name"=>$row['account_name'],
                    "objective"=>$row['objective'],
                    "spend"=> $row['spend'],

                    "clicks"=>$google->clicks,
                    "domain"=>$google->domain,
                    "cpm"=>$google->cpm,
                    "ctr"=>$google->ctr,
                    "receita"=>$google->receita,
                    "impressions"=>$google->impressions,
                    "key_value"=>$google->value,
                    "country"=>$google->country,



                ];
                array_push($report,$narray);
            }
            //echo "count:$count campaign:". $keyvalue . " value:$valuefb  pais:$pais $google <br/>";

            //echo "keyvalue $keyvalue valuefb $valuefb receita do dominio =" . $google->domain . " receita=". $google->receita." <br/>";
        }

        /* echo "</pre>";
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

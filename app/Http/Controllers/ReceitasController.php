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
        $data = [
            "domains"=>Domain::orderBy('domain')->get(),"campaigns"=>[],
            "countries"=>CountryCode::all()->sortBy("name"),
            "domain"=>"",
            "country"=>"",
            "value"=>"",
            "reports"=>[],
        ];

        return view('containers.relatorios.receitas.campanhas',$data);
    }


    public function campaigns(Request $request){

        $dolar = Cotacao::find(1);
        $dolar = $dolar->valor;

        $fbc = FacebookLastCampaign::query();

        $domain = $request->domain;
        $country = $request->country;
        $value = $request->value;

        if($domain){
            $fbc->where('campaign_name','LIKE','%'.$domain.'%');
        }
        if($country){
            $fbc->where('country','=',$country);
        }
        if($value){
            $fbc->where('campaign_name','LIKE','%'.$value.'%');
        }

        $facebook = ($fbc->get()->toArray());
        $report = [];

        foreach($facebook as $row){
            $keyvalue = $row['campaign_name'];
            $pais = $row['country'];
            $arr = explode('#',$keyvalue);
            preg_match_all('!\d+!', $arr[1], $matches);
            $valuefb = ($matches[0][0]);


            $gam = GoogleGamCampaigns::where([
                ["domain","=",$domain],
                ["name","=",'utm_campaign'],
                ["value","LIKE",'%'.$valuefb.'%'],
                ["country","=",$pais]
            ])->get();
            $count = $gam->count();
            $fbp = ($gam->first());
            if($count>0){
                $narray= [
                    "spend"=>$row['spend'],
                    "domain"=>$fbp->domain,
                    "receita"=>$fbp->receita,
                    "campaign_name"=>$row['campaign_name'],
                    "key_value"=>$fbp->value,
                    "country"=>$fbp->country
                ];
                array_push($report,$narray);
            }
            //echo "count:$count campaign:". $keyvalue . " value:$valuefb  pais:$pais $fbp <br/>";

            //echo "keyvalue $keyvalue valuefb $valuefb receita do dominio =" . $fbp->domain . " receita=". $fbp->receita." <br/>";
        }




        $data = [
            "domains"=>Domain::orderBy('domain')->get(),"campaigns"=>[],
            "countries"=>CountryCode::all()->sortBy("name"),
            "domain"=>$domain,
            "country"=>$country,
            "value"=>$value,
            "reports"=>$report,
            "dolar"=>$dolar
        ];



        return view('containers.relatorios.receitas.campanhas',$data);
    }

}

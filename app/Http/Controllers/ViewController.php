<?php

namespace App\Http\Controllers;

use App\Models\Cotacao;
use App\Models\Domain;
use App\Models\FacebookAdsAccount;
use App\Models\FacebookLastCampaign;
use App\Models\GoogleGamCampaigns;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home(){

        $facebook = FacebookLastCampaign::orderBy('id', 'DESC')->take(100)->get();
        $contas_dominios = Domain::all();
        $contas_fb = FacebookAdsAccount::all();
        $dolar = Cotacao::find(1);
        $valor = $dolar->valor;
        $custo_fb = 0;
        $receita_gl= 0;



        $campaigns = [];
        foreach($facebook as $row){
            $keyvalue = $row['campaign_name'];
            $pais = $row['country'];
            $arr = explode('#',$keyvalue);
            preg_match_all('!\d+!', $arr[1], $matches);
            $valuefb = ($matches[0][0]);
            $domain = $arr[0];
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
                    "receita"=>round(($fbp->receita * $valor),2),
                    "impressions"=>$fbp->impressions,
                    "campaign_name"=>$row['campaign_name'],
                    "key_value"=>$fbp->value,
                    "country"=>$fbp->country
                ];
                array_push($campaigns,$narray);
                $receita_gl += ($fbp->receita * $valor);
                $custo_fb += $row['spend'];
            }

        }

        $datas = [
            "campaigns"=>$campaigns,
            "contas_dominios"=>$contas_dominios->count(),
            "contas_fb"=>$contas_fb->count(),
            "receita_gl"=>round($receita_gl*$valor,2),
            "custo_fb"=>$custo_fb
        ];
        return view('containers.home',$datas);
    }
}

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
    public function home(Request $request){

        $data_inicial = $request->data_inicial;
        $data_final = $request->data_final;

        $campanhas_ativas = FacebookLastCampaign::where('status', '=', 'ACTIVE')->count();
        if($data_final && $data_inicial){
            $facebook = FacebookLastCampaign::whereBetween('date_start', [$data_inicial, $data_final])->orderBy('id', 'DESC')->get();
        }
        else{
            $facebook = FacebookLastCampaign::orderBy('id', 'DESC')->take(100)->get();
        }

        $contas_dominios = Domain::all();
        $contas_fb = FacebookAdsAccount::all();
        $dolar = Cotacao::find(1);
        $valor = $dolar->valor;
        $custo_fb = 0;
        $receita_gl= 0;


        $impressions_fb = 0;
        $campaigns = [];
        foreach($facebook as $row){
            $keyvalue = $row['campaign_name'];
            $pais = $row['country'];
            $arr = explode('#',$keyvalue);
            if(isset($arr[1])){
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
                        "cpm_gam"=>$fbp->cpm,
                        "cpc_fb"=>$row['cpc'],
                        "ctr_fb"=>$row['ctr'],
                        "clicks_fb"=>$row['clicks'],
                        "impressions"=>$fbp->impressions,
                        "campaign_name"=>$row['campaign_name'],
                        "key_value"=>$fbp->value,
                        "country"=>$fbp->country,
                        "date_start"=>$row['date_start'],
                    ];
                    array_push($campaigns,$narray);
                    $receita_gl += ($fbp->receita * $valor);
                    $custo_fb += $row['spend'];
                    $impressions_fb += $row['impressions'];
                }
            }

        }

        $datas = [
            "campaigns"=>$campaigns,
            "contas_dominios"=>$contas_dominios->count(),
            "contas_fb"=>$contas_fb->count(),
            "receita_gl"=>round($receita_gl*$valor,2),
            "custo_fb"=>$custo_fb,
            "impressions_fb"=>$impressions_fb,
            "data_inicial"=>$data_inicial,
            "data_final"=>$data_final,
            "dolar"=>$valor,
            "campanhas_ativas"=>$campanhas_ativas
        ];
        return view('containers.home',$datas);
    }
}

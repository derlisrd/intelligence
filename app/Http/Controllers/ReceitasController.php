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
        $gam = GoogleGamCampaigns::query();

        $domain = $request->domain;
        $country = $request->country;
        $value = $request->value;


        if ($domain) {
            $gam->where('domain','=',$domain);
        }
        if ($country) {
            $gam->where('country','=',$country);
        }
        if ($value) {
            $gam->where('value','LIKE',$value.'%');
        }
        $gam->where('name','=','utm_campaign');


        $campanhas = $gam->where("name","utm_campaign")->orderBy('id', 'DESC')->paginate(250);
        $reports = [];
        $idcampaign = "0";



        foreach($campanhas as $campan){
            $dominio = $campan->domain;
            $keyvalue = $campan->value;
            $receita_gam = $campan->receita;
            $impressions_gam = $campan->impressions;
            $fb = FacebookLastCampaign::query();
            if ($country) {
                $fb->where('country','=',$country);
            }
            if ($value) {
                $fb->where('campaign_name','LIKE', '%'.$keyvalue.'%');
            }


            $last = $fb->where('campaign_name', 'LIKE', '%'.$dominio.'%')->get();

            foreach($last as $r){
                if($idcampaign !== $r->campaign_id){
                    array_push($reports,[
                        "id"=>$campan->id,
                        "impressions_gam"=>$impressions_gam,
                        "name"=>$r->campaign_name,
                        "receita_gam"=>$receita_gam,
                        "spend_uss"=>round($r->spend/$dolar,2),
                        "domain" => $dominio,
                        "campaign_id" => $r->campaign_id,
                        "value"=>$keyvalue,
                        "spend"=>$r->spend,
                        "country"=>$r->country
                    ]);
                }
                $idcampaign = $r->campaign_id;
            }
        }


        $datas = [
            "domains"=>Domain::orderBy('domain')->get(),
            "countries"=>CountryCode::all()->sortBy("name"),
            "campaigns"=>$gam->where("name","utm_campaign")->orderBy('id', 'DESC')->paginate(250),
            "domain"=>$domain,
            "country"=>$country,
            "value"=>$value,
            "reports"=>$reports
        ];


        return view('containers.relatorios.receitas.campanhas',$datas);

    }

}

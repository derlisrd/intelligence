<?php

namespace App\Http\Controllers;

use App\Models\CountryCode;
use App\Models\Domain;
use App\Models\GoogleGamCampaigns;
use Illuminate\Http\Request;

class ReceitasController extends Controller
{


    public function index(){
        $data = ["domains"=>Domain::all(),"campaigns"=>[],"countries"=>CountryCode::all()];
        return view('containers.relatorios.receitas.campanhas',$data);
    }


    public function campaigns(Request $request){


        $gam = GoogleGamCampaigns::query();

        $domain = $request->domain;
        $country = $request->country;



        if ($domain) {
            $gam->where('domain','=',$domain);
        }
        if ($country) {
            $gam->where('country','=',$country);
        }
        $gam->where('name','=','utm_campaign');

        $datas = [
            "domains"=>Domain::all(),
            "campaigns"=>$gam->where("name","utm_campaign")->orderBy('id', 'DESC')->paginate(250),
            "domain"=>$domain,
            "country"=>$country
        ];


        return view('containers.relatorios.receitas.campanhas',$datas);

    }

}

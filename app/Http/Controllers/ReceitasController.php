<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\GoogleGamCampaigns;
use Illuminate\Http\Request;

class ReceitasController extends Controller
{


    public function index(){
        $data = ["domains"=>Domain::all(),"campaigns"=>[]];
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
            $gam->where('country','LIKE','%'.$country.'%');
        }

        $datas = [
            "domains"=>Domain::all(),
            "campaigns"=>$gam->where("name","utm_campaign")->orderBy('id', 'DESC')->paginate(100)
        ];


        return view('containers.relatorios.receitas.campanhas',$datas);

    }

}

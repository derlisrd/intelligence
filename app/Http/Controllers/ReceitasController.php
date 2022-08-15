<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\GoogleGamCampaigns;
use Illuminate\Http\Request;

class ReceitasController extends Controller
{


    public function index(){


        $data = ["domains"=>Domain::all()];
        return view('containers.relatorios.receitas.campanhas',$data);
    }

    public function campaigns(Request $request){

        $domain = $request->domain;
        $datas = GoogleGamCampaigns::where("domain",$domain)
                                    ->where("name","utm_campaign")
                                    ->get();

        return response()->json(["datas"=>$datas]);


    }

}

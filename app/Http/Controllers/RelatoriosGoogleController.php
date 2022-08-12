<?php

namespace App\Http\Controllers;

use App\Models\GoogleGamCampaigns;
use Illuminate\Http\Request;

class RelatoriosGoogleController extends Controller
{

    public function getCampaigns(){
        $campaigns = GoogleGamCampaigns::limit(30)->offset(30)->orderBy("id", "desc")->get();
        return view ('containers.relatorios.google.campaigns',compact('campaigns'));
    }
}

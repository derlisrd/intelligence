<?php

namespace App\Http\Controllers;

use App\Models\GoogleGamCampaigns;
use Illuminate\Http\Request;

class RelatoriosGoogleController extends Controller
{

    public function getCampaigns(){
        $campaigns = GoogleGamCampaigns::orderBy('id', 'DESC')->paginate(50);
        return view ('containers.relatorios.google.campaigns',compact('campaigns'));
    }
}

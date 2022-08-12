<?php

namespace App\Http\Controllers;

use App\Models\GoogleGamCampaigns;
use Illuminate\Http\Request;

class RelatoriosGoogleController extends Controller
{

    public function getCampaigns(){
        $google = GoogleGamCampaigns::all();
        return view ('containers.relatorios.google.campaigns',compact('google'));
    }
}

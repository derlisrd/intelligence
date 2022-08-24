<?php

namespace App\Http\Controllers;

use App\Models\FacebookLastCampaign;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home(){

        $fbcampaigns = FacebookLastCampaign::orderBy('id', 'DESC')->take(10)->get();
        $datas = [
            "fbcampaigns"=>$fbcampaigns
        ];
        return view('containers.home',$datas);
    }
}

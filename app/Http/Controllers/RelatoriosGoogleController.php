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

    public function filter(Request $request)
    {
        $gam = GoogleGamCampaigns::query();

        $domain = $request->domain;
        $name = $request->name;
        $country = $request->country;


        if ($domain) {
            $gam->where('domain','LIKE','%'.$domain.'%');
        }
        if ($country) {
            $gam->where('country','LIKE','%'.$country.'%');
        }

        if ($name) {
            $gam->where('name','LIKE','%'.$name.'%');
        }


        $data = [
            'domain' => $domain,
            'country' => $country,
            'name' => $name,
            'campaigns' => $gam->orderBy('id', 'DESC')->paginate(100),
        ];

        return view('containers.relatorios.google.campaigns',$data);
    }
}

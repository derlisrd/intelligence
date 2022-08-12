<?php

namespace App\Http\Controllers;
use App\Models\FacebookLastCampaign;
use App\Models\FacebookUser;
use Illuminate\Http\Request;

class ApiFacebookController extends Controller
{

    public function getAllCampaigns(){
        $LastCampaigns = FacebookLastCampaign::all();
        return response()->json(["data"=>$LastCampaigns]);
    }

    public function getCampaignsByAdAccountId (Request $request){
        $fbuserid = $request->fbuserid;
        $fbuser = FacebookUser::find($fbuserid);

        $LastCampaigns = FacebookLastCampaign::where("account_id", $request->act_id)->get();
        return response()->json(["data"=>$LastCampaigns]);
    }

}

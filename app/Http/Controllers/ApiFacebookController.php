<?php

namespace App\Http\Controllers;

use App\Models\FacebookAdsAccount;
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

    public function destroyAdAccount(Request $request){

        $id = $request->id;
        FacebookAdsAccount::where('id',$id)->delete();
        return response()->json(["response"=>true]);

    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookBussinessAcountsController extends Controller
{



    public function getBussinessManagerAccounts(Request $request){
        $user_id = $request->user_id;
        $access_token = "";
        $endpoint = "https://graph.facebook.com/v14.0/".$user_id."/businesses?access_token=".$access_token;

        //https://graph.facebook.com/<API_VERSION>/<BUSINESS_ID>/business_users?access_token=<ACCESS_TOKEN>
    }
}

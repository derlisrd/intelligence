<?php

namespace App\Http\Controllers;

use App\Models\FacebookAdsAccount;
use App\Models\FacebookUser;

class ConexionsController extends Controller
{


    public function facebook()
    {
        $endpoint = "https://facebook.com/" . env('FB_API_VERSION') . "/dialog/oauth";
        $params = [
            "client_id" => env("FB_APP_ID"),
            "redirect_uri" => env("FB_APP_CALLBACK"),
            "state" => "active",
            "scope" => "email,ads_management,ads_read,attribution_read,business_management,pages_manage_ads,read_insights"
        ];
        $urllogin = $endpoint . "?" . http_build_query($params);
        $breadcrumblinks = [
            [
                "active" => true,
                "title" => "Conexions",
                "route" => null // name of the route
            ]
        ];
        $fbuser = new FacebookUser();
        $fbusers = $fbuser->all();
        return view('conexions.facebook', compact('breadcrumblinks', 'urllogin', 'fbusers'));
    }



    public function facebookcallback()
    {
        if (isset($_GET['code'])) {
            $endpoint = "https://graph.facebook.com/" . env('FB_API_VERSION') . "/oauth/access_token";
            $params = [
                "client_id" => env("FB_APP_ID"),
                "client_secret" => env("FB_APP_SECRET"),
                "redirect_uri" => env("FB_APP_CALLBACK"),
                "code" => $_GET['code']
            ];
            $endpoint = $endpoint . '?' . http_build_query($params);
            $fbresponse = json_decode(getcurl($endpoint), true);
            $access_token = $fbresponse['access_token'];

            $userdata = $this->SaveUserFacebook($access_token);
            $id = $userdata->id;
            $this->SaveBussinessAccounts($id);
            $userfb = $userdata;
        }
        return view('conexions.facebookcallback', compact('userfb'));
    }



    private function SaveUserFacebook($access_token)
    {
        try {
            $endpointme = "https://graph.facebook.com/" . env('FB_API_VERSION') . "/me?fields=email,id,name&access_token=$access_token";
            $res = json_decode(getcurl($endpointme), true);
            $email = $res['email'];
            $facebook_user_id = $res['id'];
            $name = $res['name'];

            $Facebook  = new FacebookUser();
            $Facebook->email = $email;
            $Facebook->name = $name;
            $Facebook->facebook_user_id = $facebook_user_id;
            $Facebook->access_token = $access_token;
            $Facebook->save();
            return $Facebook::find($Facebook->id);
        } catch (\Throwable $th) {
            print 'Error: ' . $th->getMessage();
            die();
        }
    }


    // saving facebook bussiness accounts
    private function SaveBussinessAccounts($id)
    {
        try {
            $facebookuser = FacebookUser::find($id);
            $facebook_user_id = $facebookuser->facebook_user_id;
            $access_token = $facebookuser->access_token;
            $endpoint = "https://graph.facebook.com/" . env('FB_API_VERSION') . "/" . $facebook_user_id . "/adaccounts?fields=name,id,account_id&limit=100&access_token=" . $access_token;
            $response = json_decode(getcurl($endpoint), true);
            foreach ($response['data'] as $value) {
                $fbinsert = new FacebookAdsAccount();
                $fbinsert->facebook_users_id = $id;
                $fbinsert->account_name = $value['name'];
                $fbinsert->account_id = $value['account_id'];
                $fbinsert->act_account_id = $value['id'];
                $fbinsert->save();
            }
        } catch (\Throwable $th) {
            print 'Error: ' . $th->getMessage();
            die();
        }
    }


}

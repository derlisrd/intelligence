<?php

namespace App\Http\Controllers;

use App\Models\FacebookAdsAccount;
use App\Models\FacebookUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConexionsController extends Controller
{


    // view
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
        $breadcrumblinks = [["active" => true,"title" => "Conexions","route" => null]];

        $iduser = Auth::id();
        $fbusers = FacebookUser::where('user_id',$iduser)->get();



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
            $endpointme = "https://graph.facebook.com/" . env('FB_API_VERSION') . "/me?fields=email,id,name&access_token=$access_token";
            $res = json_decode(getcurl($endpointme), true);
            $facebook_user_id = $res['id'];

            //$userdata = $this->SaveUserFacebook($access_token);
            //$id = $userdata->id;
            //$this->SaveBussinessAccounts($id);

            $endpoint = "https://graph.facebook.com/" . env('FB_API_VERSION') . "/" . $facebook_user_id . "/adaccounts?fields=name,id,account_id&limit=100&access_token=" . $access_token;
            $response = json_decode(getcurl($endpoint), true);
            //$contas = $response['data'];

            print_r($response);
            //$userfb = $userdata;
        }

        return view('conexions.facebookshowadaccounts');
        //return view('conexions.facebookcallback', compact('userfb'));
    }







    private function SaveUserFacebook($access_token)
    {
        try {
            $endpointme = "https://graph.facebook.com/" . env('FB_API_VERSION') . "/me?fields=email,id,name&access_token=$access_token";
            $res = json_decode(getcurl($endpointme), true);
            $email = $res['email'];
            $facebook_user_id = $res['id'];
            $name = $res['name'];

            $fb = FacebookUser::where('email', $email)->get();
            $datos = [
                "name" => $name,"email" => $email,"facebook_user_id" => $facebook_user_id,"access_token" => $access_token,
                "user_id"=>Auth::id()
            ];
            if(($fb->count())>0){
                $fbu = $fb->first();
                FacebookUser::where('id',$fbu->id)->update($datos);
                return $fbu;
            }
            else{
               $userdata = FacebookUser::create($datos);
                return $userdata;
            }


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



    //show facebook ad accounts
    public function getFacebookAdAccounts(){


        $adAccounts = FacebookAdsAccount::all();
        return view('conexions.facebookAdAccounts',compact("adAccounts"));
    }


    public function destroyFacebookAdAccount(Request $request){
        FacebookAdsAccount::destroy($request->id);
        return back();
    }

}

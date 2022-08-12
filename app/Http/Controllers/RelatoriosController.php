<?php

namespace App\Http\Controllers;

use App\Models\FacebookUser;


class RelatoriosController extends Controller
{

    // show users profiles
    public function facebook(){

        $fbuser = new FacebookUser();
        $fbusers = $fbuser->all();
        $breadcrumblinks = [
            [
                "active"=>true,
                "title"=>"Facebook",
                "route"=>null// name of the route
            ]
        ];
        return view('containers.relatorios.facebook_lista',compact("fbusers","breadcrumblinks"));

    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewsController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function dashboard(){
        return view('containers.dashboard');
    }

}

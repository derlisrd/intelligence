<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatoriosController extends Controller
{
    public function facebook(){
        return view('containers.relatorios.facebook');
    }
}

<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConexionsController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\RelatoriosFacebookController;
use App\Http\Controllers\ViewsController;
use Illuminate\Support\Facades\Route;





Route::get("/login",[LoginController::class,"showLoginForm"])->name("login");
Route::get("/login",[LoginController::class,"showLoginForm"])->name("login.view");
Route::get("/auth/logout",[LoginController::class,"logout"])->name("auth.logout");
Route::post('/auth/login',[LoginController::class,"login"])->name("auth.login");


Route::middleware(['auth'])->group(function () {
    Route::get("/home",[ViewsController::class,"dashboard"])->name("home");
    Route::get("/dashboard",[ViewsController::class,"dashboard"])->name("dashboard");
    Route::get("/relatorios/facebook",[RelatoriosController::class,"facebook"])->name("relatorios.facebook");

    Route::get("/relatorios/facebook/{id_campaign}",[RelatoriosFacebookController::class,"getCampaign"])->name("relatorios.facebook.getCampaign");

    Route::get("/conexions",[ConexionsController::class,"conexions"])->name("conexions");
    Route::get("/conexions/facebook",[ConexionsController::class,"facebook"])->name("conexions.facebook");
    Route::get("/conexions/facebook/callback",[ConexionsController::class,"facebookcallback"])->name("conexions.facebook.callback");
});





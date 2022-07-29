<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConexionsController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\RelatoriosFacebookController;
use App\Http\Controllers\ViewsController;
use Illuminate\Support\Facades\Route;




Route::post('/login',[LoginController::class,"login"])->name("auth.login");



Route::get("/login",[LoginController::class,"showLoginForm"])->name("login");
Route::get("/login",[LoginController::class,"showLoginForm"])->name("login.view");


Route::get("/auth/logout",[LoginController::class,"logout"])->name("auth.logout");



Route::middleware(['auth'])->group(function () {
    Route::get("/home",[ViewsController::class,"home"])->name("home");
    Route::get("/dashboard",[ViewsController::class,"dashboard"])->name("dashboard");


    Route::get("/relatorios/facebook",[RelatoriosFacebookController::class,"getFacebookUsers"])->name("relatorios.facebook.users");
    Route::get('/relatorios/facebook/adaccounts/{user_fb_id}',[RelatoriosFacebookController::class,"getAdAccountsByUserId"])->name('relatorios.facebook.adaccounts');
    Route::get('/relatorios/facebook/{fbuser_id}/campaigns/{act_id}',[RelatoriosFacebookController::class,"getCampaignsByAdAccountId"])->name('relatorios.facebook.campaigns');
    Route::get('relatorios/facebook/{fbuser_id}/insights/{campaign_id}',[RelatoriosFacebookController::class,"getInsightsByIdCampaign"])->name('relatorios.facebook.insights.campaign');

    Route::get("/conexions",[ConexionsController::class,"conexions"])->name("conexions");
    Route::get("/conexions/facebook",[ConexionsController::class,"facebook"])->name("conexions.facebook");
    Route::get("/conexions/facebook/callback",[ConexionsController::class,"facebookcallback"])->name("conexions.facebook.callback");




});





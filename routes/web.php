<?php
use App\Http\Controllers\ApiFacebookController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConexionsController;
use App\Http\Controllers\RelatoriosFacebookController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[LoginController::class,"login"])->name("auth.login");

Route::view("/","auth.login")->name("login");
Route::view("/login","auth.login")->name("login.view");

Route::middleware(['auth'])->group(function () {

    Route::view('/dashboard','containers.dashboard') ;
    Route::view('/home','containers.dashboard')->name("home") ;

    Route::get("/relatorios/facebook",[RelatoriosFacebookController::class,"getFacebookUsers"])->name("relatorios.facebook.users");
    Route::get('/relatorios/facebook/adaccounts/{user_fb_id}',[RelatoriosFacebookController::class,"getCampaignsByAdAccountId"])->name('relatorios.facebook.adaccounts');


    Route::get('/relatorios/facebook/api/campaigns/{act_id}/{fbuser_id}',[RelatoriosFacebookController::class,"apiCampaignsByAdAccountId"])->name('relatorios.facebook.api.campaign.by.account');
    Route::get('/relatorios/facebook/api/sinc_adcampaigns/{fbuser_id}',[RelatoriosFacebookController::class,"apiSyncCampaignsByAdAccountId"])->name("relatorios.facebook.api.sinc_adcampaigns.by.account");

    Route::get("/conexions",[ConexionsController::class,"conexions"])->name("conexions");
    Route::get("/conexions/facebook",[ConexionsController::class,"facebook"])->name("conexions.facebook");
    Route::get("/conexions/facebook/callback",[ConexionsController::class,"facebookcallback"])->name("conexions.facebook.callback");

    Route::get("/api/facebook/campaigns/act_{act_id}/{fbuserid}",[ApiFacebookController::class,"getCampaignsByAdAccountId"])->name("api.facebook.getCampaigns.by.account.id");
    Route::get("/api/facebook/allcampaigns",[ApiFacebookController::class,"getAllCampaigns"])->name("api.all.facebook.getCampaigns");

});

Route::get("/auth/logout",[LoginController::class,"logout"])->name("auth.logout");




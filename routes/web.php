<?php
use App\Http\Controllers\ApiFacebookController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConexionsController;
use App\Http\Controllers\ReceitasController;
use App\Http\Controllers\RelatoriosFacebookController;
use App\Http\Controllers\RelatoriosGoogleController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[LoginController::class,"login"])->name("auth.login");

Route::view("/","auth.login")->name("login");
Route::view("/login","auth.login")->name("login.view");

Route::middleware(['auth'])->group(function () {
    Route::view('/home','containers.home')->name("home") ;

    Route::get("/relatorios/facebook",[RelatoriosFacebookController::class,"getFacebookUsers"])->name("relatorios.facebook.users");
    Route::get('/relatorios/facebook/adaccounts/{user_fb_id}',[RelatoriosFacebookController::class,"getCampaignsByAdAccountId"])->name('relatorios.facebook.adaccounts');

    Route::get('/relatorios/google',[RelatoriosGoogleController::class,"getCampaigns"])->name("relatorios.google.gam");
    Route::get('/relatorios/google/filters',[RelatoriosGoogleController::class,"filter"])->name("gam.filter");

    Route::get('relatorios/receitas',[ReceitasController::class,"index"])->name('receitas');

    Route::get('/conexions/facebookadaccounts',[ConexionsController::class,"getFacebookAdAccounts"])->name("facebook.adaccounts");
    Route::get('/conexions/facebookadaccounts/destroy/{id}',[ConexionsController::class,"destroyFacebookAdAccount"])->name("facebook.adaccount.destroy");

    Route::get("/conexions/facebook",[ConexionsController::class,"facebook"])->name("conexions.facebook");
    Route::get("/conexions/facebook/callback",[ConexionsController::class,"facebookcallback"])->name("conexions.facebook.callback");

    Route::get("/api/facebook/campaigns/act_{act_id}/{fbuserid}",[ApiFacebookController::class,"getCampaignsByAdAccountId"])->name("api.facebook.getCampaigns.by.account.id");
    Route::get("/api/facebook/allcampaigns",[ApiFacebookController::class,"getAllCampaigns"])->name("api.all.facebook.getCampaigns");
    Route::delete("/api/facebook/destroyadaccount/{id}",[ApiFacebookController::class,"destroyAdAccount"]);


});

Route::get("/auth/logout",[LoginController::class,"logout"])->name("auth.logout");







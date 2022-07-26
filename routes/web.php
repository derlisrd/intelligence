<?php
use App\Http\Controllers\ApiFacebookController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConexionsController;
use App\Http\Controllers\Cron\FacebookCampaigns;
use App\Http\Controllers\ReceitasController;
use App\Http\Controllers\RelatoriosFacebookController;
use App\Http\Controllers\RelatoriosGoogleController;

use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[LoginController::class,"login"])->name("auth.login");

Route::view("/","auth.login")->name("login")->middleware("guest");
Route::view("/login","auth.login")->name("login.view")->middleware("guest");



Route::middleware(['auth'])->group(function () {
    //views
    Route::get('/home',[ViewController::class,"home"])->name("home") ;
    Route::post('/home',[ViewController::class,"home"])->name("home_filter") ;

    //relatorios do facebook
    Route::prefix('relatorios/facebook')->group(function () {
        #Route::get("/",[RelatoriosFacebookController::class,"getFacebookUsers"])->name("relatorios.facebook.users");
        #Route::get('adaccounts/{user_fb_id}',[RelatoriosFacebookController::class,"getCampaignsByAdAccountId"])->name('relatorios.facebook.adaccounts');
        Route::get('/',[RelatoriosFacebookController::class,"getLastCampaigns"])->name('facebook.campanhas');
        Route::post('/',[RelatoriosFacebookController::class,"postCampaigns"])->name('relatorios.postCampaigns');
        Route::get('campaign/{id}',[RelatoriosFacebookController::class,"viewCampaign"])->name('facebook.campaign');
        //Route::post('campaigns/user_{user_fb_id}',[RelatoriosFacebookController::class,"getCampaigns"])->name('relatorios.getCampaigns');
        Route::get('campaigns/user_{user_fb_id}',[RelatoriosFacebookController::class,"viewCampaigns"])->name('view.relatorios.getCampaigns');
    });

    //RELATORIOS DA GOOGLE
    Route::get('/relatorios/google',[RelatoriosGoogleController::class,"getCampaigns"])->name("relatorios.google.gam");
    Route::get('/relatorios/google/filters',[RelatoriosGoogleController::class,"filter"])->name("gam.filter");

    //RELATORIOS DE RECEITAS
    Route::get('relatorios/receitas',[ReceitasController::class,"index"])->name('receitas');
    Route::post('relatorios/receitas',[ReceitasController::class,"campaigns"])->name('receitas.campaigns');

    //CONEXIONES DE FACEBOOK
    Route::get('/conexion/facebookadaccount/save/{id?}',[ConexionsController::class,"saveAdAccount"])->name('conexion.save.accounts');
    Route::get('/conexions/facebookadaccounts',[ConexionsController::class,"getFacebookAdAccounts"])->name("facebook.adaccounts");
    Route::get('/conexions/facebookadaccounts/destroy/{id}',[ConexionsController::class,"destroyFacebookAdAccount"])->name("facebook.adaccount.destroy");
    Route::get("/conexions/facebook",[ConexionsController::class,"facebook"])->name("conexions.facebook");
    Route::get("/conexions/facebook/callback",[ConexionsController::class,"facebookcallback"])->name("conexions.facebook.callback");


    //API ASINCRONOS DE FACEBOOK
    Route::get("/api/facebook/campaigns/act_{act_id}/{fbuserid}",[ApiFacebookController::class,"getCampaignsByAdAccountId"])->name("api.facebook.getCampaigns.by.account.id");
    Route::get("/api/facebook/allcampaigns",[ApiFacebookController::class,"getAllCampaigns"])->name("api.all.facebook.getCampaigns");
    Route::delete("/api/facebook/destroyadaccount/{id}",[ApiFacebookController::class,"destroyAdAccount"]);

    Route::get("/auth/logout",[LoginController::class,"logout"])->name("auth.logout");

    Route::get("fb",[FacebookCampaigns::class,"fb"]);


    Route::get("face",[FacebookCampaigns::class,"face"]);

});

















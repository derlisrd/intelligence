<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\ViewsController;
use Illuminate\Support\Facades\Route;





Route::get("/login",[LoginController::class,"showLoginForm"])->name("login.view");
Route::get("/auth/logout",[LoginController::class,"logout"])->name("auth.logout");
Route::post('/auth/login',[LoginController::class,"login"])->name("auth.login");


Route::middleware(['auth'])->group(function () {
    Route::get("/home",[ViewsController::class,"dashboard"])->name("home");
    Route::get("/dashboard",[ViewsController::class,"dashboard"])->name("dashboard");
    Route::get("/relatorios/facebook",[RelatoriosController::class,"facebook"])->name("relatorios.facebook");
});





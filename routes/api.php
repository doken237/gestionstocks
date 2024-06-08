<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\BonCommandeController;
use App\Http\Controllers\API\Ajoutcontroller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('article/create',[ArticleController::class,'create']);
    Route::post('article/update',[ArticleController::class,'update']);
    
     // route vers le controller Ajoutcontroller
    Route::post('ajout_article/create',[Ajoutcontroller::class,'create']);

    // route vers le controller BonCommande
Route::post('boncommande/create',[BonCommandeController::class,'create']);
Route::post('boncommande/update',[BonCommandeController::class,'update']);
    
});
// route pour les controllers user
Route::post('user/create',[UserController::class,'create']);
Route::post('user/update',[UserController::class,'update']);
Route::post('user/login',[UserController::class,'login']);
Route::get('user/listes',[UserController::class,'listes']);
Route::get('user/search',[UserController::class,'search']);
// route vers le controller article
Route::get('article/listes',[ArticleController::class,'listes']);
Route::get('article/search',[ArticleController::class,'search']);







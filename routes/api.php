<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\HomeController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    // Auth Cycle
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);

    //ProfileController
    Route::post('update-profile', [ProfileController::class, 'updateProfile']);
    Route::get('data-profile', [ProfileController::class, 'dataProfile']);


    //HomeController 
    Route::get('countries', [HomeController::class, 'countries']);
    Route::get('home', [HomeController::class, 'home']);
});
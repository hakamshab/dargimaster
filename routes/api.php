<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;


Route::group(['middleware' => 'api'], function($router) {

    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'login']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);


});

// customer start
  Route::post('customer/list', [App\Http\Controllers\Api\CustomerController::class, 'index']);
  Route::post('customer/add', [App\Http\Controllers\Api\CustomerController::class, 'store']);

    Route::post('customer/view', [App\Http\Controllers\Api\CustomerController::class, 'view']);
    
  Route::post('customer/update', [App\Http\Controllers\Api\CustomerController::class, 'update']);

  // end

  // orderStart
   Route::post('order/view', [App\Http\Controllers\Api\OrderController::class, 'view']);
  Route::post('order/add', [App\Http\Controllers\Api\OrderController::class, 'store']);
  Route::post('order/update', [App\Http\Controllers\Api\OrderController::class, 'update']);


  // dashbaord list

     Route::post('dashbaord/view', [App\Http\Controllers\Api\DashboardController::class, 'view']);






 

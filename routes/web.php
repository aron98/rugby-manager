<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(\App\Http\Controllers\TeamController::class)->group(function(){
    Route::get('/teams', 'index');
    Route::get('/team/{id}', 'show');
});

Route::controller(\App\Http\Controllers\TransferController::class)->group(function(){
    Route::get('/transfers', 'index');
    Route::get('/transfer/{id}', 'show');
});

Route::controller(\App\Http\Controllers\PlaceController::class)->group(function(){
    Route::get('/places', 'index');
    Route::get('/place/{id}', 'show');
});

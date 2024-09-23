<?php


use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherDataController;

Route::post('/locations', [LocationController::class, 'store']);
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/locations/{id}/average', [WeatherDataController::class, 'getAverage']);

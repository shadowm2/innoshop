<?php

use Illuminate\Support\Facades\Route;
use InnoShop\Front\Controllers\Api;

// Country & State routes
Route::prefix('api/location')->group(function () {
    // Countries
    Route::get('/countries', [Api\LocationController::class, 'countries']);
    Route::get('/countries/{id}/states', [Api\LocationController::class, 'states']);
    Route::get('/states/{id}/cities', [Api\LocationController::class, 'cities']);
});
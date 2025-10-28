<?php
use Illuminate\Support\Facades\Route;
use Plugin\Zarinpal\Controllers\ZarinpalController;

Route::post('/zarinpal/create', [ZarinpalController::class, 'create'])->name('zarinpal.create');
Route::get('/zarinpal/callback', [ZarinpalController::class, 'callback'])->name('zarinpal.callback');
Route::post('/zarinpal/notify', [ZarinpalController::class, 'notify'])->name('zarinpal.notify');

<?php
use Illuminate\Support\Facades\Route;
use Plugin\Zarinpal\Controllers\Admin\PaymentsController;

Route::prefix('admin/plugins/zarinpal')->middleware(['web', 'auth'])->group(function () {
    Route::get('/payments', [PaymentsController::class, 'index'])->name('zarinpal.admin.payments');
});

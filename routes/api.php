<?php

use App\Http\Controllers\Auth\JwtController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Commerce\{
    ProductTypeController,
    ProductController,
    PurchasesController,
};
use App\Models\Commerce\Purchase;
use Illuminate\Http\Request;

Route::prefix('auth')->group(function () {
    Route::post('login', [JwtController::class, 'login']);

    Route::middleware(['auth:api'])->get('user', function (Request $request) {
        return $request->user();
    });
});

Route::resource('product-types', ProductTypeController::class)->except(['create', 'edit']);
Route::resource('products', ProductController::class)->except(['create', 'edit']);

Route::middleware(['auth:api'])->group(function () {
    Route::resource('purchases', PurchasesController::class)->except(['create', 'edit']);
});

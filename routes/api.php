<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Providers\ProductProvider;
use App\Http\Providers\SkuProvider;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function () {

    Route::prefix('internal')->group(function () {    

        Route::resource('products', ProductProvider::class);

        Route::get('product/{sku}', [ProductProvider::class, 'showProductBySKU']);

        Route::get('getcatalogbysku', [ProductProvider::class, 'getCatalogBySKU']);

    });

});

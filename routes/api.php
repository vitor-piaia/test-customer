<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('customer')->group(function () {
    Route::get('', [CustomerController::class, 'list']);
    Route::post('store', [CustomerController::class, 'store']);
    Route::put('update/{id}', [CustomerController::class, 'update']);
    Route::delete('delete/{id}', [CustomerController::class, 'delete']);
});

Route::prefix('company')->group(function () {
    Route::get('', [CompanyController::class, 'list']);
    Route::post('store', [CompanyController::class, 'store']);
    Route::put('update/{id}', [CompanyController::class, 'update']);
    Route::delete('delete/{id}', [CompanyController::class, 'delete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

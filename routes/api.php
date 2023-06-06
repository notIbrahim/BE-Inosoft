<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Motorcycles;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vehicle;

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
Route::pattern('Specified', '[A-Za-z]+');
Route::prefix('/Motorcycle')->group(function (){
    Route::get('/{Specified}', [Vehicle::class , 'Motorcycles']);
    Route::get('/{Specified}', [Vehicle::class , 'Motorcycles']);
});

Route::prefix('/Cars')->group(function (){
    Route::get('/{Specified}', [Vehicle::class , 'Cars']);
    Route::get('/{Specified}', [Vehicle::class , 'Cars']);
});

Route::get('/Tested', [Motorcycles::class , 'Stock']);
Route::get('/{Specified}', [Vehicle::class , 'Motorcycles']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

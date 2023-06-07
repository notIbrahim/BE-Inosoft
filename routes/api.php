<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Motorcycles;
use App\Http\Controllers\TokenView;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vehicle;
use App\Http\Middleware\AuthJWT;
use App\Http\Middleware\ValidatorJWT;

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
Route::get('/', [TokenView::class, 'index'])->middleware([AuthJWT::class]);
Route::pattern('Specified', '[A-Za-z]+');
Route::prefix('/Motorcycle')->group(function (){
    Route::any('/{Specified}', [Vehicle::class , 'Motorcycles']);
})->middleware(ValidatorJWT::class);

Route::prefix('/Cars')->group(function (){
    Route::any('/{Specified}', [Vehicle::class , 'Cars']);
})->middleware(ValidatorJWT::class);

Route::get('/Tested', [Motorcycles::class , 'Stock']);
Route::get('/{Specified}', [Vehicle::class , 'Motorcycles']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

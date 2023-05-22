<?php

use App\Http\Controllers\API\Ecryption\AES256Cipher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CatchEmAll;
use App\Http\Controllers\API\V1\ImageService;

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

Route::get('/v1/generate', [CatchEmAll::class, 'generate']);
Route::get('/v1/getAvailableClasses/{num_of_classes}', [ImageService::class, 'getCaptchaClasses']);
Route::get('/v1/getImage/{class}/{reliability}', [ImageService::class, 'getImage']);
Route::get('v1/encrypt/{data}', [AES256Cipher::class, 'encrypt']);
Route::get('v1/decrypt/{data}', [AES256Cipher::class, 'decrypt']);
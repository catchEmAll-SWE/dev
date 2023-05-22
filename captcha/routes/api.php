<?php

use App\Http\Controllers\API\Ecryption\AES256Cipher;
use App\Http\Controllers\API\V1\CaptchaImgBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CatchEmAll;
use App\Http\Controllers\API\V1\ImageController;

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

Route::get('v1/encrypt/{data}', [AES256Cipher::class, 'encrypt']);
Route::get('v1/decrypt/{data}', [AES256Cipher::class, 'decrypt']);

// ImageController routes
Route::get('v1/images', [ImageController::class, 'index']);
Route::get('v1/image/{id}', [ImageController::class, 'getImageId']);

Route::get('v1/classes', [ImageController::class, 'getClasses']);
Route::get('v1/captchaclasses/{numOfClasses}', [ImageController::class, 'getCaptchaClasses']);
Route::get('/v1/image/{class}/{reliability}', [ImageController::class, 'getImagesOfClass']);

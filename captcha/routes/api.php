<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CaptchaController;
use App\Http\Controllers\AuthController;
use App\Http\Business\Ecryption\AES256Cipher;

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

Route::post('login', [AuthController::class, 'login']);

Route::group(['prefix'=>'v1', 'middleware'=>['auth:sanctum']], function(){
    Route::get('generate', [CaptchaController::class, 'generate']);
});

Route::get('v1/login-error', function(Request $request) {
    return "User is not authenticated";
})->name('not-authenticated');

Route::get('v1/generate', [CaptchaController::class, 'generate']);

Route::get('v1/encrypt/{data}', [AES256Cipher::class, 'encrypt']);
Route::get('v1/decrypt/{data}', [AES256Cipher::class, 'decrypt']);



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

Route::post('getToken', [AuthController::class, 'getToken']);

Route::group(['prefix'=>'v1', 'middleware'=>['auth:sanctum']], function(){
    Route::get('generate', [CaptchaController::class, 'generate']);
    Route::post('verify', [CaptchaController::class, 'verify']);
});

Route::get('v1/encrypt/{data}', function(Request $request, string $data){
    $algo = new AES256Cipher();
    return $algo->encrypt($data);
});

Route::get('v1/decrypt/{data}/{key}', function(Request $request, string $data, int $key){
    $algo = new AES256Cipher();
    return $algo->decrypt($data, $key);
});

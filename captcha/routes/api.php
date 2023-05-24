<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CatchEmAll;
use App\Http\Controllers\API\AuthController;

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
    Route::get('generate', [CatchEmAll::class, 'generate']);
});

Route::get('v1/login-error', function(Request $request) {
    return "User is not authenticated";
})->name('not-authenticated');





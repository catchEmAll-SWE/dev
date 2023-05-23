<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\CatchEmAll;
use App\Http\Controllers\API\V1\ImageController;
use App\Models\Image;
use App\Http\Resources\V1\ImageResource;

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
Route::get('/v1/getImage/{id}', [ImageController::class, 'getImageInBase64']);
Route::get('v1/images', [ImageController::class, 'index']);
Route::get('v1/images/{image}', function(Image $image){
    $controller = new ImageController();
    return $controller->getImageInBase64($image);
});


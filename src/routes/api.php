<?php

use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('image/upload', [ImageController::class, "upload"]);

Route::get('/createZip/{id}', [ImageController::class, 'createZip']);
Route::get('/download/{id}', [ImageController::class, 'download']);

Route::prefix('images')->group(function () {
    Route::get('/', [ImageController::class, 'show']);
    Route::get('/sort', [ImageController::class, 'sort']);
    Route::get('/{id}', [ImageController::class, 'showById']);
    Route::post('/upload', [ImageController::class, 'upload']);
});


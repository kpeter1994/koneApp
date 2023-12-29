<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ImageUploadController;

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

Route::get('/error-by-workers', [ErrorController::class, 'getCurrentErrorsGroupByWorkers'])->name('getActuallErrorsGroupByWorkers');

Route::get('/gallery', [ImageUploadController::class, 'index'])->name('gallery');

Route::post('/upload', [ImageUploadController::class, 'store'])->name('upload');


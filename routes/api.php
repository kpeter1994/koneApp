<?php

use App\Http\Controllers\Api\ChatbotController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\FirebaseNotificationController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\KoneWorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/send-message', [ChatbotController::class, 'sendMessage']);

Route::get('/not-available', [KoneWorkerController::class, 'getNotAvailableWorkers'])->name('notAvailable');


<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FirebaseNotificationController;
use App\Http\Controllers\KoneWorkerController;
use App\Http\Controllers\Mol\MolController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\WorkOrderController;
use App\Services\EquipmentService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DispatcherController;
use Inertia\Inertia;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\CallCenterReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['web'])->group(function () {

    Route::get('/', function () {
        return Inertia::render('Auth/Login', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware('auth')->group(function () {

        Route::middleware('check.kone')->group(function () {

            Route::get('/dashboard', [FeedController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

            Route::get('/kone-workers', [KoneWorkerController::class, 'index'])->name('workers.index');

            Route::get('/kone-worker', [KoneWorkerController::class, 'show'])->name('workers.show');

            Route::resource('order', WorkOrderController::class);

            Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');

            Route::resource('error', ErrorController::class);

            Route::get('export', [ErrorController::class, 'export'])->name('export');

            Route::resource('feed', FeedController::class);

            Route::patch('feed/{id}/solved', [FeedController::class, 'solvedTask'])->name('feed.solved');

            Route::get('/last-visited', [FeedController::class, 'lastVisited'])->name('lastVisited');

            Route::resource('comment', CommentController::class);

            Route::post('/import', [EquipmentService::class, 'import'])->name('import');

            Route::get('/report', [ReportController::class, 'index'])->name('report');

            Route::resource('tag', TagController::class);


        });

    });


});


Route::middleware('check.pandant')->group(function () {

    Route::resource('posts', PostController::class);

    Route::get('/mol', [MolController::class, 'index'])->name('mol.index');

    Route::resource('fougyelet', DispatcherController::class);

    Route::get('/sent-daily-report', [DispatcherController::class, 'sendReport'])->name('sendReport');

    Route::get('/event-report', [DispatcherController::class, 'export'])->name('export.report');

    Route::post('/send-event/{id}', [DispatcherController::class, 'sendEvent'])->name('sendEvent');

    Route::get('/edit-event/{id}', [DispatcherController::class, 'editEvent'])->name('editEvent');

    Route::delete('/delete-event/{id}', [DispatcherController::class, 'deleteEvent'])->name('deleteEvent');

    Route::patch('/update-event/{id}', [DispatcherController::class, 'updateEvent'])->name('updateEvent');

    Route::resource('/daily-report', DailyReportController::class);

    Route::resource('call-center-report', CallCenterReportController::class);

});





//Test view
Route::get('/test', [\App\Services\MapService::class, 'test']);

Route::get('fcm', [FirebaseNotificationController::class, 'sendNotification'])->name('fcm');


require __DIR__ . '/auth.php';

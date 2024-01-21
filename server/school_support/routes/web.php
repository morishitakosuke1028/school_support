<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\GradeClassController;
use App\Http\Controllers\GradeClassHistoryController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Child\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileController as ProfileOfChildController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/admin/index', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('users.index');
Route::get('/admin/{user}/edit', [UserController::class, 'edit'])->middleware(['auth', 'verified'])->name('users.edit');
Route::put('/admin/{user}', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('users.update');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/gradeClasses/index', [GradeClassController::class, 'index'])->name('gradeClasses.index');
    Route::get('/gradeClasses/create', [GradeClassController::class, 'create'])->name('gradeClasses.create');
    Route::post('/gradeClasses', [GradeClassController::class, 'store'])->name('gradeClasses.store');
    Route::get('/gradeClasses/{gradeClass}/edit', [GradeClassController::class, 'edit'])->name('gradeClasses.edit');
    Route::put('/gradeClasses/{gradeClass}', [GradeClassController::class, 'update'])->name('gradeClasses.update');
    Route::delete('/gradeClasses/{gradeClass}', [GradeClassController::class, 'destroy'])->name('gradeClasses.destroy');

    Route::get('/gradeClassHistories/index', [GradeClassHistoryController::class, 'index'])->name('gradeClassHistories.index');
    Route::get('/gradeClassHistories/{gradeClassHistory}/edit', [GradeClassHistoryController::class, 'edit'])->name('gradeClassHistories.edit');
    Route::put('/gradeClassHistories/{gradeClassHistory}', [GradeClassHistoryController::class, 'update'])->name('gradeClassHistories.update');
    Route::delete('/gradeClassHistories/{gradeClassHistory}', [GradeClassHistoryController::class, 'destroy'])->name('gradeClasseHistories.destroy');

    Route::get('/homeworks/index', [HomeworkController::class, 'index'])->name('homeworks.index');
    Route::get('/homeworks/{gradeClass}/edit', [HomeworkController::class, 'edit'])->name('homeworks.edit');
    Route::post('/homeworks/{homework}', [HomeworkController::class, 'bulkStore'])->name('homeworks.bulkStore');

    Route::get('/attendance/index', [DailyController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [DailyController::class, 'store'])->name('attendance.store');

    Route::get('/event/index', [EventController::class, 'index'])->name('event.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{event}/edit', [EventClassController::class, 'edit'])->name('event.edit');
    Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{event}', [EventClassController::class, 'destroy'])->name('event.destroy');

    Route::get('/admin/child/register', [RegisteredUserController::class, 'create'])
    ->name('admin.child.register');

    Route::post('/admin/child/register', [RegisteredUserController::class, 'store']);

    Route::get('/admin/child/index', [ChildController::class, 'index'])->name('admin.child.index');
    Route::get('/admin/child/{child}/edit', [ChildController::class, 'edit'])->name('admin.child.edit');
    Route::put('/admin/child/{child}', [ChildController::class, 'update'])->name('admin.child.update');
});

Route::prefix('child')->name('child.')->group(function(){

	Route::get('/dashboard', function () {
			return Inertia::render('Child/Dashboard');
	})->middleware(['auth:child', 'verified'])->name('dashboard');

	Route::middleware('auth:child')->group(function () {
        Route::get('/profile', [ProfileOfChildController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileOfChildController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileOfChildController::class, 'destroy'])->name('profile.destroy');

    });
	require __DIR__.'/child.php';
});

require __DIR__.'/auth.php';

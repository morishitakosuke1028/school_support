<?php

use App\Http\Controllers\UserController;
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
Route::get('/admin/{user}', [UserController::class, 'show'])->middleware(['auth', 'verified'])->name('users.show');
Route::get('/admin/{user}/edit', [UserController::class, 'edit'])->middleware(['auth', 'verified'])->name('users.edit');
Route::put('/admin/{user}', [UserController::class, 'update'])->middleware(['auth', 'verified'])->name('users.update');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

		Route::prefix('child')->name('child.')->group(function(){
			Route::middleware('auth:child')->group(function () {
				Route::get('register', [RegisteredUserController::class, 'create'])
				->name('register');

				Route::post('register', [RegisteredUserController::class, 'store']);
			});
		});
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

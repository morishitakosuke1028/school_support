<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\GradeClassController;
use App\Http\Controllers\GradeClassHistoryController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\GrowthController;
use App\Http\Controllers\Child\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [StaticController::class, 'index'])->name('index');

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
    Route::post('/gradeClassHistories/{gradeClassHistory}', [GradeClassHistoryController::class, 'update'])->name('gradeClassHistories.update');
    Route::delete('/gradeClassHistories/{gradeClassHistory}', [GradeClassHistoryController::class, 'destroy'])->name('gradeClasseHistories.destroy');

    Route::get('/homeworks/index', [HomeworkController::class, 'index'])->name('homeworks.index');
    Route::get('/homeworks/{gradeClass}/edit', [HomeworkController::class, 'edit'])->name('homeworks.edit');
    Route::post('/homeworks/{homework}', [HomeworkController::class, 'bulkStore'])->name('homeworks.bulkStore');

    Route::get('/attendance/index', [DailyController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [DailyController::class, 'store'])->name('attendance.store');

    Route::get('/events/index', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::get('/events/check', [EventController::class, 'check'])->name('events.check');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/contacts/index', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/growths/index', [GrowthController::class, 'index'])->name('growths.index');
    Route::get('/growths/create', [GrowthController::class, 'create'])->name('growths.create');
    Route::post('/growths', [GrowthController::class, 'store'])->name('growths.store');
    Route::get('/growths/{growth}/edit', [GrowthController::class, 'edit'])->name('growths.edit');
    Route::put('/growths/{growth}', [GrowthController::class, 'update'])->name('growths.update');
    Route::delete('/growths/{growth}', [GrowthController::class, 'destroy'])->name('growths.destroy');

    Route::get('/csvImport/create', [CsvImportController::class, 'create'])->name('csvImport.create');
    Route::post('/csvImport', [CsvImportController::class, 'store'])->name('csvImport.store');

    Route::get('/subjects/index', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    Route::get('/schedules/index', [ScheduleController::class, 'index'])->name('schedules.index');

    Route::get('/admin/child/register', [RegisteredUserController::class, 'create'])
    ->name('admin.child.register');

    Route::post('/admin/child/register', [RegisteredUserController::class, 'store']);

    Route::get('/admin/child/index', [ChildController::class, 'index'])->name('admin.child.index');
    Route::get('/admin/child/{child}/edit', [ChildController::class, 'edit'])->name('admin.child.edit');
    Route::put('/admin/child/{child}', [ChildController::class, 'update'])->name('admin.child.update');
});
Route::prefix('child')->name('child.')->group(function(){
    require __DIR__.'/child.php';
});

require __DIR__.'/auth.php';

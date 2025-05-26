<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // School
    Route::get('/player', [PlayerController::class, 'index'])->name('player');
    Route::get('/club', [ClubController::class, 'index'])->name('club');
    Route::get('/coach', [CoachController::class, 'index'])->name('coach');
    Route::get('/user', [UserController::class, 'index'])->name('user');

    Route::get('/school', [SchoolController::class, 'index'])->name('school');
    Route::post('/school/show', [SchoolController::class, 'show'])->name('school.show');
    // Route::get('/schools/{id}', [SchoolController::class, 'show']);

    Route::get('/achievement', [AchievementController::class, 'index'])->name('achievement');
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');


    //ddl
    Route::get('/districts', [SchoolController::class, 'getDistricts'])->name('districts.list');
});

require __DIR__.'/auth.php';

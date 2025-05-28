<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

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

    //athlete
    Route::get('/athlete', [AthleteController::class, 'index'])->name('athlete');
    Route::get('/athlete/create', [AthleteController::class, 'create'])->name('athlete.create');

    Route::get('/club', [ClubController::class, 'index'])->name('club');
    Route::get('/coach', [CoachController::class, 'index'])->name('coach');
    Route::get('/user', [UserController::class, 'index'])->name('user');

    Route::get('/school', [SchoolController::class, 'index'])->name('school');
    Route::post('/school/show', [SchoolController::class, 'show'])->name('school.show');
    Route::post('/school', [SchoolController::class, 'store'])->name('school.store');
    Route::put('/school/{id}', [SchoolController::class, 'update'])->name('school.update');

    //Achievement
    // Route::get('/achievement', [AchievementController::class, 'index'])->name('achievement');
    // Route::resource('achievement', AchievementController::class)->only(['index', 'update']);
    //Route::resource('achievement', AchievementController::class)->only(['index', 'update'])
    //->names(['index' => 'achievement']);
    // Achievement routes
    Route::resource('achievement', AchievementController::class)->only(['index', 'store', 'update'])
        ->names(['index' => 'achievement']);
    Route::post('/achievement', [AchievementController::class, 'store'])->name('achievement.store');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting');


    //ddl
    Route::get('/districts', [SchoolController::class, 'getDistricts'])->name('districts.list');


   
});



require __DIR__ . '/auth.php';

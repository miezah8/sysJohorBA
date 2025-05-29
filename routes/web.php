<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SanctionController;
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
    Route::resource('achievement', AchievementController::class)->only(['index', 'store', 'update'])
        ->names(['index' => 'achievement']);
    Route::post('/achievement', [AchievementController::class, 'store'])->name('achievement.store');

    Route::get('/setting', [SettingController::class, 'index'])->name('setting');

    //Club
    /*Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
    Route::post('/clubs/show', [ClubController::class, 'show'])->name('clubs.show');
    Route::post('/clubs', [ClubController::class, 'store'])->name('clubs.store');
    Route::put('/clubs/{club}', [ClubController::class, 'update'])->name('clubs.update');
    Route::get('/clubs/{club}/edit', [ClubController::class, 'edit'])->name('clubs.edit');
    */
    // 1) First, register the players-list route:
    Route::get('/clubs/{club}/players', [ClubController::class, 'players'])->name('clubs.players');
    //Route::post('/clubs/show', [ClubController::class,'show'])->name('clubs.show');
    // 2) Then your resource routes (index, create, store, show, edit, update, destroy):
    Route::resource('clubs', ClubController::class);


    //ddl
    Route::get('/districts', [SchoolController::class, 'getDistricts'])->name('districts.list');

    // states for the state dropdown
    Route::get('/states', [SchoolController::class, 'getStates'])->name('states.list');

    //Sanction
    //Route::resource('sanction', SanctionController::class);//->names('sanction');
    //Route::get('/sanction', [SanctionController::class, 'index'])->name('sanction.index');
    Route::resource('sanction', SanctionController::class)
     ->names(['index' => 'sanction',
         // you can leave the other names default:
         // 'create' => 'sanction.create',
         // 'store'  => 'sanction.store',
         // …etc.
     ]);
});



require __DIR__ . '/auth.php';

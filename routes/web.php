<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\UserController;// as AdminUserController;
use App\Http\Controllers\SanctionController;
//use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::middleware(['auth','role:admin'])
     ->prefix('admin')
     ->name('admin.users.')
     ->group(function() {
         // Senarai semua pengguna (biasanya filter status_user=0 atau 1)
         Route::get('/',                [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
         // Buka form edit untuk satu pengguna tertentu
         Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
         // Terima data dari form edit dan simpan role & permission
         Route::put('users/{user}',      [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
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
     // Organiser: boleh apply & lihat
    Route::get('sanctions',           [SanctionController::class,'index'])
        ->name('sanctions.index')
        ->middleware('can:sanction.view_own');
    Route::get('sanctions/create',    [SanctionController::class,'create'])
        ->name('sanctions.create')
        ->middleware('can:sanction.apply');
    Route::post('sanctions',          [SanctionController::class,'store'])
        ->name('sanctions.store')
        ->middleware('can:sanction.apply');
    Route::get('sanctions/{sanction}',[SanctionController::class,'show'])
        ->name('sanctions.show')
        ->middleware('can:sanction.view_own');

    // Reviewer (State BA): boleh lihat semua & approve/reject
    Route::get('admin/sanctions',     [SanctionController::class,'adminIndex'])
        ->name('sanctions.admin.index')
        ->middleware('can:sanction.review');
    Route::get('admin/sanctions/{sanction}/edit',
        [SanctionController::class,'edit'])
        ->name('sanctions.edit')
        ->middleware('can:sanction.review');
    Route::put('admin/sanctions/{sanction}',
        [SanctionController::class,'update'])
        ->name('sanctions.update')
        ->middleware('can:sanction.review');
     
});

    Route::middleware(['auth','role:admin'])->prefix('admin')->group(function(){
    // show list of pending users
    Route::get('users/pending', [AdminUserController::class,'pending'])
        ->name('admin.users.pending');

    // show review form
    Route::get('users/{user}/review', [AdminUserController::class,'review'])
        ->name('admin.users.review');

    // handle approve+assign
    Route::post('users/{user}/review', [AdminUserController::class,'approve'])
        ->name('admin.users.approve');

    // optional: reject
    Route::post('users/{user}/reject', [AdminUserController::class,'reject'])
        ->name('admin.users.reject');
    });



require __DIR__ . '/auth.php';

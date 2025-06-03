<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvitationMail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('auth.login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])
     ->middleware(['auth','verified'])
     ->name('dashboard');

// ==============================
// ROUTE ADMIN → Manage registrations & assign role/permission
// Role: hanya 'admin' yang boleh akses
// ==============================
Route::middleware(['auth','role:admin'])
     ->prefix('admin')
     ->name('admin.users.')
     ->group(function() {
         // Daftar semua pengguna (bisa ditambahkan filter status_user)
         Route::get('/',                [AdminUserController::class, 'index'])->name('index');
         // Form edit user tertentu (assign role/permission)
         Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('edit');
         Route::post('/users', [AdminUserController::class, 'store'])->name('store');
         Route::put('/users/assign-role', [AdminUserController::class, 'assignRole'])->name('assignRole');
         Route::post('users/invite', [AdminUserController::class, 'invite'])->name('invite');

         // Update data user (syncRoles + syncPermissions)
         Route::put('users/{user}',      [AdminUserController::class, 'update'])->name('update');

         // Tambahan: pending & review
         Route::get('users/pending',      [AdminUserController::class, 'pending'])->name('pending');
         Route::get('users/{user}/review', [AdminUserController::class, 'review'])->name('review');
         Route::post('users/{user}/review',[AdminUserController::class, 'approve'])->name('approve');
         Route::post('users/{user}/reject',[AdminUserController::class, 'reject'])->name('reject');
     });


    // ==============================
    // ROUTE DASHBOARD (harus auth + verified)
    // ==============================
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth','verified'])->name('dashboard');


    // ==============================
    // ROUTE UTAMA (harus 'auth')
    // ==============================
    Route::middleware('auth')->group(function () {

    // ------------------------------
    // Profile → Edit profil sendiri
    // ------------------------------
    Route::get('/profile',            [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',         [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ------------------------------
    // Modul: Athlete
    // Permissions: view athlete, add athlete, edit athlete, delete athlete
    // ------------------------------
    Route::middleware('permission:view athlete')->group(function() {
        Route::get('/athlete', [AthleteController::class, 'index'])->name('athlete.index');
        Route::get('/athlete/sch/{id}', [AthleteController::class, 'show'])->name('athlete.show');
    });
    Route::middleware('permission:add athlete')->group(function() {
        Route::get('/athlete/form', [AthleteController::class, 'create'])->name('athlete.form');
        Route::post('/athlete', [AthleteController::class, 'store'])->name('athlete.store');
    });
    Route::middleware('permission:edit athlete')->group(function() {
        Route::get('/athlete/{athlete}/edit', [AthleteController::class, 'edit'])->name('athlete.edit');
        Route::put('/athlete/{athlete}', [AthleteController::class, 'update'])->name('athlete.update');
    });

    Route::middleware('permission:delete athlete')->group(function() {
        Route::delete('/athlete/{athlete}', [AthleteController::class, 'destroy'])->name('athlete.destroy');
    });

    // ------------------------------
    // Modul: Coach (jika terpisah)
    // Permissions: view coach, add coach, edit coach, delete coach
    // ------------------------------
    Route::middleware('permission:view coach')->group(function() {
        Route::get('/coach',            [CoachController::class, 'index'])->name('coach.index');
        // Route::get('/coach/{coach}',    [CoachController::class, 'show'])->name('coach.show');
        Route::get('/coach/{coach}/players', [CoachController::class, 'players'])->name('coach.players');
    });
    // Route::middleware('permission:add coach')->group(function() {
    //     Route::get('/coach/create',     [CoachController::class, 'create'])->name('coach.create');
    //     Route::post('/coach',           [CoachController::class, 'store'])->name('coach.store');
    // });
    // Route::middleware('permission:edit coach')->group(function() {
    //     Route::get('/coach/{coach}/edit',[CoachController::class, 'edit'])->name('coach.edit');
    //     Route::put('/coach/{coach}',     [CoachController::class, 'update'])->name('coach.update');
    // });
    Route::middleware('permission:add coach')->group(function() {
        Route::get('/coach/add', [CoachController::class, 'form'])->name('coach.create');
        Route::post('/coach',           [CoachController::class, 'store'])->name('coach.store');
    });
    Route::middleware('permission:edit coach')->group(function() {
        Route::get('/coach/{id}/edit', [CoachController::class, 'form'])->name('coach.edit');
        Route::put('/coach/{coach}',     [CoachController::class, 'update'])->name('coach.update');
    });
    Route::middleware('permission:delete coach')->group(function() {
        Route::delete('/coach/{coach}',  [CoachController::class, 'destroy'])->name('coach.destroy');
    });

    // ------------------------------
    // Modul: Club
    // Permissions: view club, add club, edit club, delete club
    // ------------------------------
    Route::middleware('permission:view club')->group(function() {
        Route::get('/clubs',             [ClubController::class, 'index'])->name('clubs.index');
        Route::get('/clubs/{club}',      [ClubController::class, 'show'])->name('clubs.show');
        Route::get('/clubs/{club}/players', [ClubController::class, 'players'])->name('clubs.players');
        // Route::resource('clubs', ClubController::class);

    });
    Route::middleware('permission:add club')->group(function() {
        Route::get('/clubs/create',      [ClubController::class, 'create'])->name('clubs.create');
        Route::post('/clubs',            [ClubController::class, 'store'])->name('clubs.store');
    });
    Route::middleware('permission:edit club')->group(function() {
        Route::get('/clubs/{club}/edit', [ClubController::class, 'edit'])->name('clubs.edit');
        Route::put('/clubs/{club}',      [ClubController::class, 'update'])->name('clubs.update');
    });
    Route::middleware('permission:delete club')->group(function() {
        Route::delete('/clubs/{club}',   [ClubController::class, 'destroy'])->name('clubs.destroy');
    });

    // ------------------------------
    // Modul: School
    // Permissions: view school, add school, edit school, delete school
    // ------------------------------
    Route::middleware('permission:view school')->group(function() {
        Route::get('/school',                 [SchoolController::class, 'index'])->name('school.index');
        Route::get('/school/{id}', [SchoolController::class, 'show'])->name('school.show');
    });
    Route::middleware('permission:add school')->group(function() {
        // Route::get('/school/create',          [SchoolController::class, 'create'])->name('school.create');   //xpakai sbb function create via ajax
        Route::post('/school',                [SchoolController::class, 'store'])->name('school.store');
    });
    Route::middleware('permission:edit school')->group(function() {
        //Route::get('/school/{school}/edit',   [SchoolController::class, 'edit'])->name('school.edit');
        //Route::put('/school/{school}',        [SchoolController::class, 'update'])->name('school.update');
        // Route::post('/school/show', [SchoolController::class, 'show'])->name('school.show');
        Route::put('/school/{id}', [SchoolController::class, 'update'])->name('school.update');
    });
    Route::middleware('permission:delete school')->group(function() {
        Route::delete('/school/{school}',     [SchoolController::class, 'destroy'])->name('school.destroy');
    });

    // ------------------------------
    // AJAX: Districts & States (dipakai di form School)
    // ------------------------------
    Route::get('/districts', [SchoolController::class, 'getDistricts'])->name('districts.list');
    Route::get('/states',    [SchoolController::class, 'getStates'])->name('states.list');
    Route::get('/nationality', [AthleteController::class, 'getNationality'])->name('nationality.list');
    Route::get('/ajax/school', [AthleteController::class, 'getSchool'])->name('school.list'); //try tambah sebab pada bgian route bawah xjumpa .index>>/ajax
    Route::get('/ajax/clubs', [AthleteController::class, 'getClub'])->name('club.list'); //try tambah sebab pada bgian route bawah xjumpa .index>>/ajax
    Route::get('/ajax/coach', [AthleteController::class, 'getCoach'])->name('coach.list'); //try tambah sebab pada bgian route bawah xjumpa .index>>/ajax

    // ------------------------------
    // Modul: Sanction (resource + custom routes)
    // Permissions: view sanction, add sanction, edit sanction, delete sanction, sanction.review, sanction.apply
    // ------------------------------
    // Resource routes (index, create, store, show, edit, update, destroy)
    /*Route::resource('sanction', SanctionController::class)
        ->names([
            'index'   => 'sanction.index',
            'create'  => 'sanction.create',
            'store'   => 'sanction.store',
            'show'    => 'sanction.show',
            'edit'    => 'sanction.edit',
            'update'  => 'sanction.update',
            'destroy' => 'sanction.destroy',
        ]);*/
    // Middleware berbasis permission:
    //  - Organiser: apply & view own → sanction.apply, sanction.view_own
    //  - Reviewer: review (lihat semua & approve/reject) → sanction.review
    Route::middleware('permission:view_own sanction')->group(function() {
        Route::get('sanctions', [SanctionController::class, 'index'])->name('sanction.index');
    });

    Route::middleware('permission:apply sanction')->group(function() {
        Route::get('sanctions/create', [SanctionController::class, 'create'])->name('sanction.create');
        Route::post('sanctions',       [SanctionController::class, 'store'])->name('sanction.store');
    });

    Route::middleware('permission:view_own sanction')->group(function() {
        Route::get('sanctions/{sanction}', [SanctionController::class, 'show'])->name('sanction.show');
    });

    Route::middleware('permission:review sanction')->group(function() {
        Route::get('admin/sanctions',                    [SanctionController::class, 'adminIndex'])->name('sanctions.admin.index');
        Route::get('admin/sanctions/{sanction}/edit',    [SanctionController::class, 'edit'])->name('sanctions.admin.edit');
        Route::put('admin/sanctions/{sanction}',         [SanctionController::class, 'update'])->name('sanctions.admin.update');
    });

    // ------------------------------
    // Modul: Achievement
    // Permissions: view achievement, add achievement, edit achievement, delete achievement
    // ------------------------------
    Route::middleware('permission:view achievement')->group(function() {
        //Route::get('/achievement',           [AchievementController::class, 'index'])->name('achievement.index');
        Route::resource('achievement', AchievementController::class)->only(['index', 'store', 'update'])->names(['index' => 'achievement.index']);
    });
    Route::middleware('permission:add achievement')->group(function() {
        Route::post('/achievement',          [AchievementController::class, 'store'])->name('achievement.store');
    });
    Route::middleware('permission:edit achievement')->group(function() {
        Route::patch('/achievement/{achievement}', [AchievementController::class,'update'])->name('achievement.update');
        
    });
    // (Jika ada destroy)
    Route::middleware('permission:delete achievement')->group(function() {
        Route::delete('/achievement/{achievement}', [AchievementController::class,'destroy'])->name('achievement.destroy');
    });

    // ------------------------------
    // Modul: Setting
    // Permissions: view setting, edit setting
    // ------------------------------
    Route::middleware('permission:view setting')->group(function() {
        Route::get('/setting',              [SettingController::class, 'index'])->name('setting.index');
    });
    Route::middleware('permission:edit setting')->group(function() {
        Route::put('/setting',              [SettingController::class, 'update'])->name('setting.update');
    });
});

Route::get('/test-mail', function () {
    // Give yourself a dummy URL or token
    $inviteUrl = url('/register?test=1');
    Mail::to('anyone@anywhere.test')->send(new UserInvitationMail($inviteUrl));
    return 'Mail sent (check storage/logs/laravel.log).';
});

// Akhir group 'auth'

// ------------------------------
// Authentication (Login, Register, Password Reset, dsb.)
// ------------------------------
require __DIR__.'/auth.php';

<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FacilityController;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvitationMail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\District;
use Illuminate\Support\Facades\Storage;
use App\Models\SanctionDocument;

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
         // Daftar semua pengguna (boleh ditambahkan filter status_user)
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
     
/*Route::middleware(['auth','role:admin'])
     ->prefix('reports')
     ->name('reports.')
     ->group(function(){
         Route::get('/',               [ReportController::class,'index'])->name('index');
         Route::get('create',          [ReportController::class,'create'])->name('create');
         Route::post('/',              [ReportController::class,'store'])->name('store');
         Route::get('{report}',        [ReportController::class,'show'])->name('show');
         Route::post('{report}/run',   [ReportController::class,'generate'])->name('generate');
         Route::get('{report}/export', [ReportController::class,'export'])->name('export');
         Route::delete('{report}',     [ReportController::class,'destroy'])->name('destroy');
     });*/
  Route::middleware(['auth','verified'])->group(function(){
  // list all reports
  Route::get('/reports', [ReportController::class,'index'])
       ->name('reports.index');

  // run & view a single report
  Route::post('/reports/{report}/run', [ReportController::class,'run'])
       ->name('reports.run');

  // export CSV
  Route::post('/reports/{report}/export', [ReportController::class,'export'])
       ->name('reports.export');
});


Route::middleware('auth')->group(function(){
    Route::get('/facilities',          [FacilityController::class,'index'])->name('facilities.index');
    Route::post('/facilities',         [FacilityController::class,'store'])->name('facilities.store');
    Route::match(['put','patch'], '/facilities/{facility}', [FacilityController::class,'update'])->name('facilities.update');
    Route::delete('/facilities/{facility}',  [FacilityController::class,'destroy'])->name('facilities.destroy');
});
    // ==============================
    // ROUTE DASHBOARD (harus auth + verified)
    // ==============================
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['auth','verified'])->name('dashboard');


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
/*    Route::resource('athlete', AthleteController::class)
     ->only(['index','create','store','show'])
     ->middleware('auth');
*/
    // View / list athletes
    Route::get('/athlete', [AthleteController::class, 'index'])
        ->name('athlete.index')
        ->middleware(['auth','permission:view athlete']);

    // Show the “create new” form
    Route::get('/athlete/create', [AthleteController::class, 'create'])
        ->name('athlete.create')
        ->middleware(['auth','permission:add athlete']);
    
    Route::get('/districts', [AthleteController::class,'districtList'])->name('districts.list');
    Route::get('/ajax/states',    [AthleteController::class, 'stateList'])->name('states.list');
    Route::get('/ajax/school', [AthleteController::class, 'getSchool'])->name('school.list');
    
    // Store new athlete
    Route::post('/athlete', [AthleteController::class, 'store'])
        ->name('athlete.store')
        ->middleware(['auth','permission:add athlete']);

    // Show single athlete details
    Route::get('/athlete/{athlete}', [AthleteController::class, 'show'])
        ->name('athlete.show')
        ->middleware(['auth','permission:view athlete']);

    // Show the “edit” form
    Route::get('/athlete/{athlete}/edit', [AthleteController::class, 'edit'])
        ->name('athlete.edit')
        ->middleware(['auth','permission:edit athlete']);

    // Update athlete
    Route::put('/athlete/{athlete}', [AthleteController::class, 'update'])
        ->name('athlete.update')
        ->middleware(['auth','permission:edit athlete']);

    // (and if you support delete:)
    Route::delete('/athlete/{athlete}', [AthleteController::class, 'destroy'])
        ->name('athlete.destroy')
        ->middleware(['auth','permission:delete athlete']);

/*    Route::middleware('permission:view athlete')->group(function() {
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
*/
    // ------------------------------
    // Modul: Coach (jika terpisah)
    // Permissions: view coach, add coach, edit coach, delete coach
    // ------------------------------
    Route::middleware('auth')->group(function(){
    // resource routes for coach
    Route::resource('coach', CoachController::class)
         ->except(['show']);

    Route::get('/coach/create',               [CoachController::class,'create'])->name('coach.create');
    Route::post('/coach',                     [CoachController::class,'store'  ])->name('coach.store');
    // helper endpoint for AJAX-loading districts by state
    Route::get('/coach/districts/{stateId}',  [CoachController::class,'districtsByState'])->name('coach.districts');
    Route::get('/coach/{coach}', [CoachController::class, 'show'])->name('coach.show');
    
    });
    
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
        //Route::get('/coach/add', [CoachController::class, 'form'])->name('coach.create');
        Route::post('/coach',           [CoachController::class, 'store'])->name('coach.store');
    });
    Route::middleware('permission:edit coach')->group(function() {
        //Route::get('/coach/{id}/edit', [CoachController::class, 'form'])->name('coach.edit');
        Route::put('/coach/{coach}',     [CoachController::class, 'update'])->name('coach.update');
    });
    Route::middleware('permission:delete coach')->group(function() {
        Route::delete('/coach/{coach}',  [CoachController::class, 'destroy'])->name('coach.destroy');
    });

    // ------------------------------
    // Modul: Club
    // Permissions: view club, add club, edit club, delete club
    // ------------------------------
    
// view & edit (admin + club)
Route::middleware(['auth','role:admin|club'])->group(function() {
    Route::get('/clubs',            [ClubController::class,'index'])->name('clubs.index');
    Route::get('/clubs/{club}',     [ClubController::class,'show'])->name('clubs.show');
    Route::get('/clubs/{club}/edit',[ClubController::class,'edit'])->name('clubs.edit');
    Route::put('/clubs/{club}',     [ClubController::class,'update'])->name('clubs.update');
    Route::get('/clubs/{club}/players', [ClubController::class, 'players'])->name('clubs.players');
    Route::post('/clubs',            [ClubController::class, 'store'])->name('clubs.store');
    Route::get('/api/districts/{state_id}', function($state_id) {
        return District::where('state_id', $state_id)
                    ->select('id_district','district_name')
                    ->get();
    });
});

// delete (admin only)
Route::middleware(['auth','role:admin'])->group(function() {
    Route::delete('/clubs/{club}',  [ClubController::class,'destroy'])->name('clubs.destroy');
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
    //Route::middleware('permission:apply sanction')->group(function() {
        Route::get('sanctions/create', [SanctionController::class, 'create'])->name('sanction.create');
        Route::post('sanctions',       [SanctionController::class, 'store'])->name('sanction.store');
    //});
    
    Route::middleware('permission:view_own sanction')->group(function() {
        Route::get('sanctions', [SanctionController::class, 'index'])->name('sanction.index');
    });



    Route::middleware('permission:view_own sanction')->group(function() {
        Route::get('sanctions/{sanction}', [SanctionController::class, 'show'])->name('sanction.show');
        Route::get('sanctions/{sanction}/documents/{doc}', function($sanctionId, $docId) {
        // 1) Load the record (optionally: verify it belongs to the current user)
        $doc = SanctionDocument::where('sanction_request_id',$sanctionId)
                            ->findOrFail($docId);
        // 2) Make sure it exists on disk
        $disk   = Storage::disk('public');
        $path   = $doc->path;  // e.g. "1/myfile.pdf"
        if (! $disk->exists($path)) {
            abort(404, 'File not found');
        }

        // 3) Stream it back
        return response()->file(
        $disk->path($path),
        [ 'Content-Disposition' => 'inline; filename="'.$doc->filename.'"' ]
        );
    })->name('sanction.documents.view')
    ->middleware(['auth','permission:view_own sanction']);                            
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

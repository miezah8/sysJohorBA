<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserRegistered; // kita akan buat notifikasi ini

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'ic_number'         => ['required', 'string', 'max:20', 'unique:users,ic_number'],
            'contact_no'        => ['required', 'string', 'max:20'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Buat rekod pengguna, tetapkan status_user = 0 (pending)
        $user = User::create([
            'name'          => $request->name,
            'ic_number'     => $request->ic_number,
            'contact_no'    => $request->contact_no,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'status_user'   => '0',            // pending
            'first_login'   => '1',            // logic first-login
        ]);

        // 2b) Create an empty (or partially‐populated) detail row
        $user->detail()->create([
            'ic_no'           => $request->ic_number,
            'nationality'     => null,    // or default country id
            'address'         => '',      // or null if you make the column nullable
            'postcode'        => '',
            'district_id'     => 0,       // or null / a default “unknown” district
            'state_id'        => 0,       // likewise
            'gender'          => '-',     // you could default to '-'
            'race'            => '',
            'profile_picture' => '',
            'ic_picture'      => null,
        ]);

        // 3. Trigger event Registered (jika anda guna event listener lain)
        event(new Registered($user));

        // 4. Notifikasi kepada semua admin
        // Kita andaikan role 'admin' memang wujud (hasil seeder RolePermissionSeeder)
        $admins = Role::findByName('admin')->users; 
        Notification::send($admins, new NewUserRegistered($user));

        // 5. Jangan login auto, terus redirect ke halaman “thank you” atau login
        return redirect()->route('login')
                         ->with('status', 'Thank you! Your Registration is has been sent to System Admin. 
                         Please wait for Admin verification.');
    }
}

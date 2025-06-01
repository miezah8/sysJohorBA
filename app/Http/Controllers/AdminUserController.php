<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // 1) list all pending registrations
    public function pending()
    {
        $users = User::where('registration_status','pending')->paginate(20);
        return view('admin.users.pending', compact('users'));
    }

    // 2) show the “review & assign” form
    public function review(User $user)
    {
        $roles       = \Spatie\Permission\Models\Role::all();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('admin.users.review', compact('user','roles','permissions'));
    }

    // 3) approve + assign roles & permissions
    public function approve(Request $r, User $user)
    {
        $r->validate([
          'roles'       => 'required|array',
          'permissions' => 'sometimes|array'
        ]);

        // 3a) sync roles
        $user->syncRoles($r->roles);

        // 3b) optionally sync extra permissions
        if($r->filled('permissions')){
          $user->syncPermissions($r->permissions);
        }

        // 3c) mark approved so they can now log in
        $user->registration_status = 'approved';
        $user->save();

        // notify user by email, etc.
        // $user->notify(new UserApprovedNotification);

        return redirect()->route('admin.users.pending')
                         ->with('success','User approved and roles assigned.');
    }

    // 4) reject (optional)
    public function reject(User $user)
    {
        $user->registration_status = 'rejected';
        $user->save();
        // or $user->delete();
        return back()->with('success','User rejected.');
    }
}

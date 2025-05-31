<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Papar senarai pengguna (misalnya yang pending dan aktif)
     */
    public function index()
    {
        // Jika anda mahu hanya yang pending:
        // $users = User::where('status_user', '0')->orderBy('created_at', 'desc')->paginate(10);
        // Jika anda mahu semua (pending + active):
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Papar form edit untuk set Role & Permissions (akses modul)
     */
    public function edit(User $user)
    {
        // Semua role yang wujud dalam sistem (contoh: admin, athlete, coach, club)
        $roles = Role::all();

        // Senarai modul yang anda cari (contohnya: 'sanction', 'jurulatih', 'kelab', 'pemain')
        // Pastikan anda pernah ciptakan permissions untuk modul‐modul ini di seeder
        $modules = ['sanction', 'jurulatih','kelab','pemain'];

        // Tindakan (actions) untuk setiap modul—pastikan sepadan dengan permission yang anda cipta
        $actions = ['apply','view','add','edit','delete','approve','reject'];
        // Contoh: permission strings: "apply sanction", "view jurulatih", "add kelab", dsb.

        return view('admin.users.edit', compact('user','roles','modules','actions'));
    }

    /**
     * Simpan perubahan Status, Role, dan Permissions untuk pengguna
     */
    public function update(Request $request, User $user)
    {
        // 1) Validasi input asas
        $request->validate([
            'status_user' => 'required|in:0,1',
            'role'        => 'required|exists:roles,name',
            'permissions' => 'array', // optional, nanti dibina dari modul+action
        ]);

        // 2) Update status_user (0=pending, 1=active)
        $user->status_user = $request->status_user;
        $user->save();

        // 3) Sync role: (buang semua role sedia ada & gantikan dengan yg baru)
        $user->syncRoles([$request->role]);

        // 4) Sync permissions:
        //    Data form akan datang sebagai array multi‐dimensi:
        //    permissions = [
        //      'sanction' => ['apply','view'],
        //      'jurulatih'=> ['view','add'],
        //      …
        //    ]
        $perms = [];
        if ($request->has('permissions')) {
            foreach ($request->permissions as $module => $acts) {
                foreach ($acts as $act) {
                    // Butir permission = "{action} {module}"
                    $perms[] = "{$act} {$module}";
                }
            }
        }
        // Padam semua permission lama dan gantikan dengan $perms
        $user->syncPermissions($perms);

        return redirect()
            ->route('admin.users.index')
            ->with('success','Pengguna berjaya dikemaskini (status, role, permissions).');
    }
}

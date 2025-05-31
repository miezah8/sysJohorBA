<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1) Modul & tindakan
        $modules = ['jurulatih','kelab','pemain'];
        $actions = ['add','edit','view','delete'];

        // 2) Buat setiap permission: "add jurulatih", "edit jurulatih", ...
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name'        => "{$action} {$module}"],
                    ['description' => ucfirst($action) . " on {$module} module"]
                );
            }
        }

        // 3) Buat role asas
        $roles = ['admin','athlete','coach','club'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // 4) Assign **semua** permission kepada admin
        $admin = Role::where('name','admin')->first();
        $admin->syncPermissions(Permission::all());
    }
}

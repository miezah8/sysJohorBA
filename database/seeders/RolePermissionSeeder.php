<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Senarai modul & tindakan standard
        $modules = ['athlete', 'coach', 'club', 'school', 'achievement'];
        $actions = ['view', 'add', 'edit', 'delete'];

        // 2. Cipta permissions untuk setiap kombinasi modul + tindakan
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => "{$action} {$module}"],
                    ['guard_name' => 'web']
                );
            }
        }

        // 3. Senarai semua roles yang ingin diwujudkan
        $roles = ['admin', 'athlete', 'coach', 'club', 'state_ba', 'technical', 'organiser'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
        }

        // 4. Assign SEMUA permission kepada role admin
        $admin = Role::where('name', 'admin')->first();
        $admin->syncPermissions(Permission::all());

        // 5. Assign permission tertentu kepada role lain
        Role::where('name', 'athlete')->first()?->syncPermissions([
            'view athlete',
            'view_own sanction',
            'apply sanction',
        ]);

        Role::where('name', 'coach')->first()?->syncPermissions([
            'view athlete',
            'add athlete',
            'view coach',
            'add coach',
            'view club',
            'add club',
            'view_own sanction', 
            'apply sanction',
        ]);

        Role::where('name', 'club')->first()?->syncPermissions([
            'view club',
            'add club',
        ]);

        Role::where('name', 'organiser')->first()?->syncPermissions([
            'view achievement',
            'add achievement',
            'view_own sanction', 
            'apply sanction',
        ]);

        Role::where('name', 'state_ba')->first()?->syncPermissions([
            'view achievement',
            'edit achievement',
            'delete achievement',
            'view_own sanction', 
            'apply sanction',
        ]);
    }
}
















/*
class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Senarai modul dan tindakan
        $modules = ['athlete', 'coach', 'club', 'school', 'achievement'];
        $actions = ['view', 'add', 'edit', 'delete'];

        // 1. Cipta permissions untuk setiap module-action
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => "{$action} {$module}"],
                    ['guard_name' => 'web']
                );
            }
        }

        // 2. Cipta roles
        $roles = ['admin', 'athlete', 'coach', 'club', 'state_ba', 'technical', 'organiser'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
        }

        // 3. Assign all permissions to admin
        $admin = Role::where('name', 'admin')->first();
        $admin->syncPermissions(Permission::all());

        // 4. Assign selected permissions to other roles
        Role::where('name', 'athlete')->first()?->syncPermissions([
            'view athlete',
        ]);

        Role::where('name', 'coach')->first()?->syncPermissions([
            'view athlete',
            'add athlete',
            'view coach',
            'add coach',
        ]);

        Role::where('name', 'club')->first()?->syncPermissions([
            'view club',
            'add club',
            'view coach',
        ]);

        Role::where('name', 'organiser')->first()?->syncPermissions([
            'view achievement',
            'add achievement',
        ]);

        Role::where('name', 'state_ba')->first()?->syncPermissions([
            'view achievement',
            'edit achievement',
            'delete achievement',
        ]);

        // Tambah lebih banyak syncPermissions mengikut keperluan
    }
}
*/

/*
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

        //test 1 jun 2.16am
        Permission::firstOrCreate(['name' => 'view athlete']);
        Permission::firstOrCreate(['name' => 'add athlete']);
        Permission::firstOrCreate(['name' => 'edit athlete']);
        Permission::firstOrCreate(['name' => 'delete athlete']);
        // … permission lainnya …
        $admin = Role::firstOrCreate(['name'=>'admin']);
        $admin->syncPermissions(Permission::all()); // Admin dapat semua
        $athleteRole = Role::firstOrCreate(['name'=>'athlete']);
        $athleteRole->syncPermissions(['view athlete']); // Hanya boleh lihat daftar
// dst.

    }
}
*/
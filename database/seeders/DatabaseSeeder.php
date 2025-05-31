<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1) Create Permissions first (optional: you can skip permissions
        //    if you only want simple “roles” without fine-grained “permissions”.)
        Permission::firstOrCreate(['name'=>'athlete.view']);
        Permission::firstOrCreate(['name'=>'athlete.create']);
        Permission::firstOrCreate(['name'=>'athlete.update']);
        Permission::firstOrCreate(['name'=>'athlete.delete']);

        Permission::firstOrCreate(['name'=>'coach.view']);
        Permission::firstOrCreate(['name'=>'coach.create']);
        Permission::firstOrCreate(['name'=>'coach.update']);
        Permission::firstOrCreate(['name'=>'coach.delete']);

        Permission::firstOrCreate(['name'=>'club.view']);
        Permission::firstOrCreate(['name'=>'club.update']);

        // 2) Create Roles & attach Permissions

        // Athlete role: can only manage “their own” athlete record
        $athleteRole = Role::firstOrCreate(['name'=>'athlete']);
        $athleteRole->syncPermissions([
          'athlete.view','athlete.create','athlete.update'
        ]);

        // Coach role: can manage coaches + athletes + update club
        $coachRole = Role::firstOrCreate(['name'=>'coach']);
        $coachRole->syncPermissions([
          'coach.view','coach.create','coach.update',
          'athlete.view','athlete.create','athlete.update',
          'club.update'
        ]);

        // Admin role: give every single permission
        $adminRole = Role::firstOrCreate(['name'=>'admin']);
        $adminRole->syncPermissions(Permission::all());
    }
}

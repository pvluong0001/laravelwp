<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Role::truncate();
        $roles = config('global.admin.roles');
        foreach($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }

        Permission::truncate();
        $permissions = config('global.admin.permissions');
        foreach($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
    }
}

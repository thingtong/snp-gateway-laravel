<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => UserRoles::Root->value, 'guard_name' => 'api']);
        Role::create(['name' => UserRoles::Admin->value, 'guard_name' => 'api']);
        Role::create(['name' => UserRoles::User->value, 'guard_name' => 'api']);
    }
}

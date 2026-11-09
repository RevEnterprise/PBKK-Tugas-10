<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $permissions = ['dashboard.view', 'projects.view', 'projects.delete'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $staff = Role::firstOrCreate(['name' => 'Staf', 'guard_name' => 'web']);
        $admin->syncPermissions($permissions);
        $staff->syncPermissions(['dashboard.view', 'projects.view']);

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@pbkk.test'],
            ['name' => 'Administrator Demo', 'password' => 'password', 'email_verified_at' => now()]
        );
        $adminUser->syncRoles([$admin]);

        $staffUser = User::updateOrCreate(
            ['email' => 'staf@pbkk.test'],
            ['name' => 'Staf Demo', 'password' => 'password', 'email_verified_at' => now()]
        );
        $staffUser->syncRoles([$staff]);
        if ($staffUser->projects()->count() === 0) {
            Project::factory()->count(3)->create(['user_id' => $staffUser->id]);
        }
    }
}

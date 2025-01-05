<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Section;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MainDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user = 'System';

        $create_role_super_admin = 'Super Admin';
        $create_role_admin = 'Admin';
        $create_role_user = 'User';

        /** Reset Cached Roles and Permissions */
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /** Create Permission */
        $permissions = getArrayAllPermission();
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        /** Create Role */
        $role_super_admin = Role::create([
            'guard_name' => 'web',
            'name' => $create_role_super_admin,
        ]);

        $role_admin = Role::create([
            'guard_name' => 'web',
            'name' => $create_role_admin,
        ]);

        $role_user = Role::create([
            'guard_name' => 'web',
            'name' => $create_role_user,
        ]);

        /** Create User */
        $user_super_admin = User::create([
            'name' => 'Super Admin',
            'slug' => Str::slug('Super Admin'),
            'email' => 'superadmin@mail.com',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'image' => config('common.no_image'),
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'status' => 1,
            'remember_token' => Str::random(10),
            'created_by' => $default_user,
        ]);

        $user_admin = User::create([
            'name' => 'Admin',
            'slug' => Str::slug('Admin'),
            'email' => 'admin@mail.com',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'image' => config('common.no_image'),
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'status' => 1,
            'remember_token' => Str::random(10),
            'created_by' => $default_user,
        ]);

        $user_user = User::create([
            'name' => 'User',
            'slug' => Str::slug('User'),
            'email' => 'user@mail.com',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'image' => config('common.no_image'),
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'status' => 1,
            'remember_token' => Str::random(10),
            'created_by' => $default_user,
        ]);

        /** Assign Role to User */
        $user_super_admin->assignRole($role_super_admin);
        $user_admin->assignRole($role_admin);
        $user_user->assignRole($role_user);
    }
}

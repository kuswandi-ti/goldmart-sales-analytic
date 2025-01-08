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

        $create_role_user = 'Sales';

        /** Reset Cached Roles and Permissions */
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /** Create Permission */
        $permissions = getArraySalesPermission();
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        /** Create Role */
        $role_sales = Role::create([
            'guard_name' => 'web',
            'name' => $create_role_user,
        ]);

        /** Create User */
        $user_sales = User::create([
            'name' => 'Sales 1',
            'slug' => Str::slug('Sales 1'),
            'email' => 'sales1@goldmart.co.id',
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
        $user_sales->assignRole($role_sales);
    }
}

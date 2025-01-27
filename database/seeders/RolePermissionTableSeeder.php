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

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user = 'System';

        $create_role_super_admin = 'Super Admin';
        $create_role_admin = 'Admin';
        $create_role_manajemen = 'Manajemen';
        $create_role_sales = 'Sales';

        /** Reset Cached Roles and Permissions */
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /** Create Permission */
        $permissions = getArraySalesPermission();
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
        $role_admin->givePermissionTo(Permission::all());

        $role_manajemen = Role::create([
            'guard_name' => 'web',
            'name' => $create_role_manajemen,
        ]);

        $role_sales = Role::create([
            'guard_name' => 'web',
            'name' => $create_role_sales,
        ]);
        $role_sales->givePermissionTo(['customer visit create', 'customer visit index']);

        /** Create User */
        $user_super_admin = User::create([
            'name' => 'Super Admin',
            'slug' => Str::slug('Super Admin'),
            'email' => 'kuswandi.ti@gmail.com',
            'username' => 'kuswandi.ti@gmail.com',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'image' => config('common.no_image'),
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'remember_token' => Str::random(10),
            'id_sales_person' => 1,
            'kode_sales' => 'SLS001',
            'nama_sales' => 'Non Sales',
            'created_by' => $default_user,
        ]);

        $user_admin = User::create([
            'name' => 'Rudi',
            'slug' => Str::slug('Rudi'),
            'email' => 'rudi@goldmart.co.id',
            'username' => 'rudi@goldmart.co.id',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'image' => config('common.no_image'),
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'remember_token' => Str::random(10),
            'id_sales_person' => 1,
            'kode_sales' => 'SLS001',
            'nama_sales' => 'Non Sales',
            'created_by' => $default_user,
        ]);

        $user_manajemen = User::create([
            'name' => 'Awi',
            'slug' => Str::slug('Awi'),
            'email' => 'awi@goldmart.co.id',
            'username' => 'awi@goldmart.co.id',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'image' => config('common.no_image'),
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'remember_token' => Str::random(10),
            'id_sales_person' => 1,
            'kode_sales' => 'SLS001',
            'nama_sales' => 'Non Sales',
            'created_by' => $default_user,
        ]);

        $sales_kantor_pusat = User::create([
            'name' => 'User Sales Kantor Pusat',
            'slug' => Str::slug('User Sales Kantor Pusat'),
            'email' => '111',
            'username' => '111',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'remember_token' => Str::random(10),
            'id_sales_person' => 2,
            'kode_sales' => 'SLS002',
            'nama_sales' => 'Sales Kantor Pusat',
            'created_by' => $default_user,
        ]);

        $sales_jakarta = User::create([
            'name' => 'User Sales Jakarta',
            'slug' => Str::slug('User Sales Jakarta'),
            'email' => '222',
            'username' => '222',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'remember_token' => Str::random(10),
            'id_sales_person' => 3,
            'kode_sales' => 'SLS003',
            'nama_sales' => 'Sales Jakarta',
            'created_by' => $default_user,
        ]);

        $sales_bekasi = User::create([
            'name' => 'User Sales Bekasi',
            'slug' => Str::slug('User Sales Bekasi'),
            'email' => '333',
            'username' => '333',
            'email_verified_at' => saveDateTimeNow(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'join_date' => saveDateNow(),
            'approved' => 1,
            'approved_at' => saveDateTimeNow(),
            'approved_by' => $default_user,
            'remember_token' => Str::random(10),
            'id_sales_person' => 4,
            'kode_sales' => 'SLS004',
            'nama_sales' => 'Sales Bekasi',
            'created_by' => $default_user,
        ]);

        /** Assign Role to User */
        $user_super_admin->assignRole($role_super_admin);
        $user_admin->assignRole($role_admin);
        $user_manajemen->assignRole($role_manajemen);
        $sales_kantor_pusat->assignRole($role_sales);
        $sales_jakarta->assignRole($role_sales);
        $sales_bekasi->assignRole($role_sales);
    }
}

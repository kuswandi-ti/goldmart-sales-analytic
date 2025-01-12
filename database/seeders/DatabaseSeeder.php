<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\StoreTableSeeder;
use Database\Seeders\RangeHargaTableSeeder;
use Database\Seeders\SalesPersonTableSeeder;
use Database\Seeders\SettingSystemTableSeeder;
use Database\Seeders\RolePermissionTableSeeder;
use Database\Seeders\BrandAndTipeBarangTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionTableSeeder::class);
        $this->call(SettingSystemTableSeeder::class);
        $this->call(BrandAndTipeBarangTableSeeder::class);
        $this->call(RangeHargaTableSeeder::class);
        $this->call(KotaTableSeeder::class);
        $this->call(SalesPersonTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(CounterTableSeeder::class);
    }
}

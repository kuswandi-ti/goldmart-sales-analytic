<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MainDataSeeder;
use Database\Seeders\SettingSystemTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MainDataSeeder::class);
        $this->call(SettingSystemTableSeeder::class);
        $this->call(BrandAndTipeBarangTableSeeder::class);
        $this->call(RangeHargaTableSeeder::class);
    }
}

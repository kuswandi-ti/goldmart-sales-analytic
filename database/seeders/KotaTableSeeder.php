<?php

namespace Database\Seeders;

use App\Models\Kota;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            ['nama' => strtoupper('Jakarta'), 'slug' => Str::slug('Jakarta'), 'created_by' => $user],
            ['nama' => strtoupper('Bogor'), 'slug' => Str::slug('Bogor'), 'created_by' => $user],
            ['nama' => strtoupper('Depok'), 'slug' => Str::slug('Depok'), 'created_by' => $user],
            ['nama' => strtoupper('Tangerang'), 'slug' => Str::slug('Tangerang'), 'created_by' => $user],
            ['nama' => strtoupper('Bekasi'), 'slug' => Str::slug('Bekasi'), 'created_by' => $user],
            ['nama' => strtoupper('Cianjur'), 'slug' => Str::slug('Cianjur'), 'created_by' => $user],
            ['nama' => strtoupper('Bandung'), 'slug' => Str::slug('Bandung'), 'created_by' => $user],
            ['nama' => strtoupper('Serang'), 'slug' => Str::slug('Serang'), 'created_by' => $user],
            ['nama' => strtoupper('Semarang'), 'slug' => Str::slug('Semarang'), 'created_by' => $user],
            ['nama' => strtoupper('Surakarta'), 'slug' => Str::slug('Surakarta'), 'created_by' => $user],
            ['nama' => strtoupper('Surabaya'), 'slug' => Str::slug('Surabaya'), 'created_by' => $user],
            ['nama' => strtoupper('Malang'), 'slug' => Str::slug('Malang'), 'created_by' => $user],
            ['nama' => strtoupper('Bandar Lampung'), 'slug' => Str::slug('Bandar Lampung'), 'created_by' => $user],
            ['nama' => strtoupper('Palembang'), 'slug' => Str::slug('Palembang'), 'created_by' => $user],
            ['nama' => strtoupper('Medan'), 'slug' => Str::slug('Medan'), 'created_by' => $user],
            ['nama' => strtoupper('Padang'), 'slug' => Str::slug('Padang'), 'created_by' => $user],
            ['nama' => strtoupper('Pekanbaru'), 'slug' => Str::slug('Pekanbaru'), 'created_by' => $user],
            ['nama' => strtoupper('Batam'), 'slug' => Str::slug('Batam'), 'created_by' => $user],
            ['nama' => strtoupper('Bali'), 'slug' => Str::slug('Bali'), 'created_by' => $user],
            ['nama' => strtoupper('Makassar'), 'slug' => Str::slug('Makassar'), 'created_by' => $user],
            ['nama' => strtoupper('Samarinda'), 'slug' => Str::slug('Samarinda'), 'created_by' => $user],
            ['nama' => strtoupper('Pontianak'), 'slug' => Str::slug('Pontianak'), 'created_by' => $user],
            ['nama' => strtoupper('Banjarmasin'), 'slug' => Str::slug('Banjarmasin'), 'created_by' => $user],
            ['nama' => strtoupper('Manado'), 'slug' => Str::slug('Manado'), 'created_by' => $user],
        ];
        foreach ($input as $item) {
            Kota::create($item);
        }
    }
}

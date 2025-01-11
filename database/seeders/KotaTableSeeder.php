<?php

namespace Database\Seeders;

use App\Models\Kota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            ['nama' => strtoupper('Jakarta'), 'created_by' => $user],
            ['nama' => strtoupper('Bogor'), 'created_by' => $user],
            ['nama' => strtoupper('Depok'), 'created_by' => $user],
            ['nama' => strtoupper('Tangerang'), 'created_by' => $user],
            ['nama' => strtoupper('Bekasi'), 'created_by' => $user],
            ['nama' => strtoupper('Cianjur'), 'created_by' => $user],
            ['nama' => strtoupper('Bandung'), 'created_by' => $user],
            ['nama' => strtoupper('Serang'), 'created_by' => $user],
            ['nama' => strtoupper('Semarang'), 'created_by' => $user],
            ['nama' => strtoupper('Surakarta'), 'created_by' => $user],
            ['nama' => strtoupper('Surabaya'), 'created_by' => $user],
            ['nama' => strtoupper('Malang'), 'created_by' => $user],
            ['nama' => strtoupper('Bandar Lampung'), 'created_by' => $user],
            ['nama' => strtoupper('Palembang'), 'created_by' => $user],
            ['nama' => strtoupper('Medan'), 'created_by' => $user],
            ['nama' => strtoupper('Padang'), 'created_by' => $user],
            ['nama' => strtoupper('Pekanbaru'), 'created_by' => $user],
            ['nama' => strtoupper('Batam'), 'created_by' => $user],
            ['nama' => strtoupper('Bali'), 'created_by' => $user],
            ['nama' => strtoupper('Makassar'), 'created_by' => $user],
            ['nama' => strtoupper('Samarinda'), 'created_by' => $user],
            ['nama' => strtoupper('Pontianak'), 'created_by' => $user],
            ['nama' => strtoupper('Banjarmasin'), 'created_by' => $user],
            ['nama' => strtoupper('Manado'), 'created_by' => $user],
        ];
        foreach ($input as $item) {
            Kota::create($item);
        }
    }
}

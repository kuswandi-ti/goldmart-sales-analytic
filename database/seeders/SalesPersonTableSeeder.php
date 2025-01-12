<?php

namespace Database\Seeders;

use App\Models\SalesPerson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SalesPersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            [
                'kode' => 'SLS001',
                'slug' => Str::slug('SLS001'),
                'nama' => 'Non Sales',
                'id_store' => 1,
                'kode_store' => 'STR001',
                'nama_store' => 'Kantor Pusat',
                'kota_store' => 'JAKARTA',
                'created_by' => $user
            ],
            [
                'kode' => 'SLS002',
                'slug' => Str::slug('SLS002'),
                'nama' => 'Sales Kantor Pusat',
                'id_store' => 1,
                'kode_store' => 'STR001',
                'nama_store' => 'Kantor Pusat',
                'kota_store' => 'JAKARTA',
                'created_by' => $user
            ],
            [
                'kode' => 'SLS003',
                'slug' => Str::slug('SLS003'),
                'nama' => 'Sales Jakarta',
                'id_store' => 2,
                'kode_store' => 'STR002',
                'nama_store' => 'Seibu Grand Indonesia',
                'kota_store' => 'JAKARTA',
                'created_by' => $user
            ],
            [
                'kode' => 'SLS004',
                'slug' => Str::slug('SLS004'),
                'nama' => 'Sales Bekasi',
                'id_store' => 3,
                'kode_store' => 'STR003',
                'nama_store' => 'Metropolitan Mall',
                'kota_store' => 'BEKASI',
                'created_by' => $user
            ],
        ];
        foreach ($input as $item) {
            SalesPerson::create($item);
        }
    }
}

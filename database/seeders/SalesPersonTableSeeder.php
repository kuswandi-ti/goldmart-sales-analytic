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
                'kode' => 'SLS0001',
                'slug' => Str::slug('SLS0001'),
                'nama' => 'Non Sales',
                'nik' => '-',
                'id_store' => 1,
                'kode_store' => 'STR001',
                'nama_store' => 'Kantor Pusat',
                'kota_store' => 'JAKARTA',
                'created_by' => $user
            ],
            [
                'kode' => 'SLS0002',
                'slug' => Str::slug('SLS0002'),
                'nama' => 'Sales Kantor Pusat',
                'nik' => '111',
                'id_store' => 1,
                'kode_store' => 'STR001',
                'nama_store' => 'Kantor Pusat',
                'kota_store' => 'JAKARTA',
                'created_by' => $user
            ],
            [
                'kode' => 'SLS0003',
                'slug' => Str::slug('SLS0003'),
                'nama' => 'Sales Jakarta',
                'nik' => '222',
                'id_store' => 2,
                'kode_store' => 'STR002',
                'nama_store' => 'Seibu Grand Indonesia',
                'kota_store' => 'JAKARTA',
                'created_by' => $user
            ],
            [
                'kode' => 'SLS0004',
                'slug' => Str::slug('SLS0004'),
                'nama' => 'Sales Bekasi',
                'nik' => '333',
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

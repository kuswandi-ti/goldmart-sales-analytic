<?php

namespace Database\Seeders;

use App\Models\RangeHarga;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class RangeHargaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            ['nama' => '0 - 5 juta', 'slug' => Str::slug('0 - 5 juta'), 'harga_min' => 0, 'harga_max' => 5000000, 'created_by' => $user],
            ['nama' => '5 - 10 juta', 'slug' => Str::slug('5 - 10 juta'), 'harga_min' => 5000001, 'harga_max' => 10000000, 'created_by' => $user],
            ['nama' => '10 - 15 juta', 'slug' => Str::slug('10 - 15 juta'), 'harga_min' => 10000001, 'harga_max' => 15000000, 'created_by' => $user],
            ['nama' => '15 - 20 juta', 'slug' => Str::slug('15 - 20 juta'), 'harga_min' => 15000001, 'harga_max' => 20000000, 'created_by' => $user],
            ['nama' => '20 - 30 juta', 'slug' => Str::slug('20 - 30 juta'), 'harga_min' => 20000001, 'harga_max' => 30000000, 'created_by' => $user],
            ['nama' => '30 - 50 juta', 'slug' => Str::slug('30 - 50 juta'), 'harga_min' => 30000001, 'harga_max' => 50000000, 'created_by' => $user],
            ['nama' => '50 - 100 juta', 'slug' => Str::slug('50 - 100 juta'), 'harga_min' => 50000001, 'harga_max' => 100000000, 'created_by' => $user],
            ['nama' => '> 100 juta', 'slug' => Str::slug('> 100 juta'), 'harga_min' => 100000001, 'harga_max' => 0, 'created_by' => $user],
        ];
        foreach ($input as $item) {
            RangeHarga::create($item);
        }
    }
}

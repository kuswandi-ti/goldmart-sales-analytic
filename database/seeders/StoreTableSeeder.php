<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            ['kode' => 'STR001', 'slug' => Str::slug('STR001'), 'nama' => 'Kantor Pusat', 'kota' => 'JAKARTA', 'created_by' => $user],
            ['kode' => 'STR002', 'slug' => Str::slug('STR002'), 'nama' => 'Seibu Grand Indonesia', 'kota' => 'JAKARTA', 'created_by' => $user],
            ['kode' => 'STR003', 'slug' => Str::slug('STR003'), 'nama' => 'Metropolitan Mall', 'kota' => 'BEKASI', 'created_by' => $user],
            ['kode' => 'STR004', 'slug' => Str::slug('STR004'), 'nama' => 'Supermall Karawaci', 'kota' => 'TANGERANG', 'created_by' => $user],
            ['kode' => 'STR005', 'slug' => Str::slug('STR005'), 'nama' => 'Margocity Mall', 'kota' => 'DEPOK', 'created_by' => $user],
            ['kode' => 'STR006', 'slug' => Str::slug('STR006'), 'nama' => 'Bandung Indah Plaza', 'kota' => 'BANDUNG', 'created_by' => $user],
            ['kode' => 'STR007', 'slug' => Str::slug('STR007'), 'nama' => 'Gressmall', 'kota' => 'GRESIK', 'created_by' => $user],
            ['kode' => 'STR008', 'slug' => Str::slug('STR008'), 'nama' => 'Paragon Mall', 'kota' => 'SEMARANG', 'created_by' => $user],
            ['kode' => 'STR009', 'slug' => Str::slug('STR009'), 'nama' => 'Matahari Ambarrukmo', 'kota' => 'YOGYAKARTA', 'created_by' => $user],
            ['kode' => 'STR010', 'slug' => Str::slug('STR0010'), 'nama' => 'Tunjungan Plaza 3', 'kota' => 'SURABAYA', 'created_by' => $user],
            ['kode' => 'STR011', 'slug' => Str::slug('STR0011'), 'nama' => 'Mall Olympic Garden', 'kota' => 'MALANG', 'created_by' => $user],
            ['kode' => 'STR012', 'slug' => Str::slug('STR0012'), 'nama' => 'Palembang Icon', 'kota' => 'PALEMBANG', 'created_by' => $user],
            ['kode' => 'STR013', 'slug' => Str::slug('STR0013'), 'nama' => 'DeliPark', 'kota' => 'MEDAN', 'created_by' => $user],
            ['kode' => 'STR014', 'slug' => Str::slug('STR0014'), 'nama' => 'Level 21', 'kota' => 'BALI', 'created_by' => $user],
            ['kode' => 'STR015', 'slug' => Str::slug('STR0015'), 'nama' => 'Sarinah', 'kota' => 'JAKARTA', 'created_by' => $user],
            ['kode' => 'STR016', 'slug' => Str::slug('STR0016'), 'nama' => 'Metro Senayan', 'kota' => 'JAKARTA', 'created_by' => $user],
        ];
        foreach ($input as $item) {
            Store::create($item);
        }
    }
}

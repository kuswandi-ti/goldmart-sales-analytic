<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\TipeBarang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class BrandAndTipeBarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        /** Create Brand & Tipe Barang */
        $goldmart = Brand::create([
            'nama' => 'Goldmart',
            'slug' => Str::slug('Goldmart'),
            'created_by' => $user,
        ]);
        $tipe_barang_goldmart = [
            ['nama' => 'Ring', 'id_brand' => $goldmart->id, 'created_by' => $user],
            ['nama' => 'Pendant', 'id_brand' => $goldmart->id, 'created_by' => $user],
            ['nama' => 'Necklace', 'id_brand' => $goldmart->id, 'created_by' => $user],
            ['nama' => 'Earring', 'id_brand' => $goldmart->id, 'created_by' => $user],
            ['nama' => 'Bracelet', 'id_brand' => $goldmart->id, 'created_by' => $user],
        ];
        foreach ($tipe_barang_goldmart as $item) {
            TipeBarang::create($item);
        }

        $goldmaster = Brand::create([
            'nama' => 'Goldmaster',
            'slug' => Str::slug('Goldmaster'),
            'created_by' => $user,
        ]);
        $tipe_barang_goldmaster = [
            ['nama' => 'Ring', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Pendant', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Necklace', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Earring', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Bracelet', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Bangle', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Collier', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Tietack', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Brooch', 'id_brand' => $goldmaster->id, 'created_by' => $user],
            ['nama' => 'Charm', 'id_brand' => $goldmaster->id, 'created_by' => $user],
        ];
        foreach ($tipe_barang_goldmaster as $item) {
            TipeBarang::create($item);
        }
    }
}

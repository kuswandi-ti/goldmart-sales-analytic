<?php

namespace Database\Seeders;

use App\Models\SettingSystem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            ['key' => 'site_title_2', 'value' => 'Goldmart Sales Analytic (GSA)', 'created_by' => $user],
            ['key' => 'tahun_periode_aktif_2', 'value' => date('Y'), 'created_by' => $user],
            ['key' => 'kode_dokumen_customer_visit', 'value' => 'CVI', 'created_by' => $user],
            ['key' => 'kode_dokumen_store', 'value' => 'STR', 'created_by' => $user],
            ['key' => 'kode_dokumen_sales_person', 'value' => 'SLS', 'created_by' => $user],
        ];
        foreach ($input as $item) {
            SettingSystem::create($item);
        }
    }
}

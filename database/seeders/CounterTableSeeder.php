<?php

namespace Database\Seeders;

use App\Models\Counter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CounterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            ['kode_transaksi' => 'STR', 'bulan' => date('m'), 'tahun' => date('Y'), 'nomor_terakhir' => 16, 'created_by' => $user],
            ['kode_transaksi' => 'SLS', 'bulan' => date('m'), 'tahun' => date('Y'), 'nomor_terakhir' => 4, 'created_by' => $user],
        ];
        foreach ($input as $item) {
            Counter::create($item);
        }
    }
}

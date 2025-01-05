<?php

namespace Database\Seeders;

use App\Models\FormatTime;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FormatTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = 'Super Admin';

        $input = [
            ['code' => 'h:i:sA', 'text' => '12 Hour(s) (' . date('h:i:sA') . ')', 'created_by' => $user],
            ['code' => 'H:i:s', 'text' => '24 Hour(s) (' . date('H:i:s') . ')', 'created_by' => $user],
        ];
        foreach ($input as $item) {
            FormatTime::create($item);
        }
    }
}

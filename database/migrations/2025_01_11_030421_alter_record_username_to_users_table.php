<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $rows = DB::table('users')->get(['id', 'slug']);
        foreach ($rows as $row) {
            DB::table('users')
                ->where('id', $row->id)
                ->update(['username' => $row->slug]);
        }

        $items = [
            ['id' => 1, 'id_sales_person' => 1, 'kode_sales' => 'SLS001', 'nama_sales' => 'Non Sales'],
            ['id' => 2, 'id_sales_person' => 1, 'kode_sales' => 'SLS001', 'nama_sales' => 'Non Sales'],
            ['id' => 3, 'id_sales_person' => 1, 'kode_sales' => 'SLS001', 'nama_sales' => 'Non Sales'],
            ['id' => 4, 'id_sales_person' => 1, 'kode_sales' => 'SLS001', 'nama_sales' => 'Non Sales'],
        ];
        foreach ($items as $item) {
            DB::table('users')
                ->where('id', $item['id'])
                ->update(
                    [
                        'id_sales_person' => $item['id_sales_person'],
                        'kode_sales' => $item['kode_sales'],
                        'nama_sales' => $item['nama_sales'],
                    ]
                );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // $rows = DB::table('users')->get(['id']);
        // foreach ($rows as $row) {
        //     DB::table('users')
        //         ->where('id', $row->id)
        //         ->delete();
        // }
    }
};

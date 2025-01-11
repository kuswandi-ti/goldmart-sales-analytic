<?php

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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $rows = DB::table('users')->get(['id']);
        foreach ($rows as $row) {
            DB::table('users')
                ->where('id', $row->id)
                ->delete();
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement("
            CREATE VIEW view_kredit_nasabah
            AS
            SELECT
                A.*,
                B.kode AS kode_nasabah,
                B.nama AS nama_nasabah,
                B.email,
                B.no_tlp,
                B.alamat AS alamat_nasabah
            FROM
                kredit_nasabah A
                INNER JOIN nasabah B ON A.id_nasabah = B.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement("DROP VIEW view_kredit_nasabah");
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('id_sales_person')->nullable()->after('remember_token');
            $table->string('kode_sales')->nullable()->after('id_sales_person');
            $table->string('nama_sales')->nullable()->after('kode_sales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_sales_person');
            $table->dropColumn('kode_sales');
            $table->dropColumn('nama_sales');
        });
    }
};

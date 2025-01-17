<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_visit', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen', 50);
            $table->date('tgl_visit')->default(new Expression('(CURDATE())'));
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('week')->default(0);
            $table->integer('quarter')->default(0);
            $table->string('nama_customer')->nullable();
            $table->string('parameter_1')->nullable();
            $table->string('parameter_2')->nullable();
            $table->string('keterangan')->nullable();
            $table->bigInteger('id_sales_person')->nullable();
            $table->string('kode_sales')->nullable();
            $table->string('nama_sales')->nullable();
            $table->bigInteger('id_store')->nullable();
            $table->string('kode_store')->nullable();
            $table->string('nama_store')->nullable();
            $table->string('kota_store')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('restored_at')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('restored_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_visit');
    }
};

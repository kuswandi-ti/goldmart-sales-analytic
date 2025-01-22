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
        Schema::create('sales_person', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50);
            $table->string('slug');
            $table->string('nama');
            $table->string('nik', 50);
            $table->bigInteger('id_store')->nullable();
            $table->string('kode_store')->nullable();
            $table->string('nama_store')->nullable();
            $table->string('kota_store')->nullable();
            $table->boolean('status_aktif')->default(1)->comment('1 = Aktif, 0 = Non Aktif');
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
        Schema::dropIfExists('sales_person');
    }
};

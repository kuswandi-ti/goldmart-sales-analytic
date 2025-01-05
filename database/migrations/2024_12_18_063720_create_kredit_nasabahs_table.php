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
        Schema::create('kredit_nasabah', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_nasabah');
            /*$table->string('kode_nasabah');
            $table->string('nama_nasabah');
            $table->string('email')->nullable();
            $table->string('tlp_nasabah')->nullable();
            $table->text('alamat_nasabah')->nullable();*/
            $table->date('tgl_pencairan')->nullable();
            $table->date('tgl_incoming')->nullable();
            $table->string('rekening_pencairan')->nullable();
            $table->string('nama_barang')->nullable();
            $table->text('image')->nullable();
            $table->integer('qty')->default(0);
            $table->decimal('nilai_pencairan', 20, 2)->default(0);
            $table->decimal('total_nilai_kredit', 20, 2)->default(0);
            $table->decimal('margin_keuntungan', 20, 2)->default(0);
            $table->decimal('angsuran', 20, 2)->default(0);
            $table->integer('tenor')->default(0);
            $table->string('turun_plafon')->nullable();
            $table->string('periode_bulan')->nullable();
            $table->integer('bulan')->default(0);
            $table->integer('tahun')->default(0);
            $table->string('mitra')->nullable();
            $table->enum('status_kredit', ['Berjalan', 'Lunas'])->default('Berjalan');
            $table->date('tgl_lunas')->nullable();
            // $table->enum('status_pengambilan_barang', ['Belum Diambil', 'Pending', 'Sudah Diambil']);
            $table->enum('status_kirim_barang', ['Belum Dikirim', 'Sudah Dikirim']);
            $table->date('tgl_kirim_barang')->nullable();
            $table->text('note_kirim_barang')->nullable();
            // $table->date('tgl_kirim_barang')->nullable();
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
        Schema::dropIfExists('kredit_nasabah');
    }
};

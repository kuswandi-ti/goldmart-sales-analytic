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
        Schema::table('customer_visit_detail', function (Blueprint $table) {
            $table->string('parameter_main')->nullable()->after('id_visit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_visit_detail', function (Blueprint $table) {
            //
        });
        Schema::table('customer_visit_detail', function (Blueprint $table) {
            $table->dropColumn('parameter_main');
        });
    }
};

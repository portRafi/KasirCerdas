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
        Schema::create('laba_rugis', function (Blueprint $table) {
            $table->id();
            $table->integer('laba_bersih', 10, 2);
            $table->integer('total_pemasukan', 10, 2);
            $table->integer('total_pengeluaran', 10, 2);
            $table->integer('penjualan', 10, 2);
            $table->integer('harga_pokok_penjualan', 10, 2);
            $table->integer('pemasukan_lain', 10, 2);
            $table->integer('pengeluaran_lain', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laba_rugis');
    }
};

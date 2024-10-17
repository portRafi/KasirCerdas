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
        Schema::create('labarugis', function (Blueprint $table) {
            $table->id();
            $table->decimal('laba_bersih', 10, 2);
            $table->decimal('total_pemasukan', 10, 2);
            $table->decimal('total_pengeluaran', 10, 2);
            $table->decimal('penjualan', 10, 2);
            $table->decimal('harga_pokok_penjualan', 10, 2);
            $table->decimal('pemasukan_lain', 10, 2);
            $table->decimal('pengeluaran_lain', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labarugis');
    }
};

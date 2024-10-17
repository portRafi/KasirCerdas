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
        Schema::create('penjualan_kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->integer('jumlah_barang');
            $table->decimal('total_pendapatan', 10,2);
            $table->decimal('keuntungan', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_kategoris');
    }
};

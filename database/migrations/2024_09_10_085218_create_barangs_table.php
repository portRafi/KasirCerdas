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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->varchar('kode')->unique();
            $table->varchar('nama');
            $table->varchar('kategori');
            $table->decimal('harga_beli' ,10,2);
            $table->decimal('harga_jual' ,10,2);
            $table->integer('stok');
            $table->integer('diskon');
            $table->varchar('tipe_barang')->default('default');
            $table->varchar('satuan');
            $table->integer('berat');
            $table->integer('letak_rak');
            $table->varchar('keteragan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};

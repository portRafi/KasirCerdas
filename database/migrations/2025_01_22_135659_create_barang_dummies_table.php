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
        Schema::create('barang_dummies', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('kategori');
            $table->decimal('harga_beli' ,10,2);
            $table->decimal('harga_jual' ,10,2);
            $table->integer('stok');
            $table->integer('diskon')->nullable();
            $table->string('satuan');
            $table->integer('berat');
            $table->integer('letak_rak');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_dummies');
    }
};

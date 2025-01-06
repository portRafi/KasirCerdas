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
        Schema::create('barang_after_checkouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnis_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('cabangs_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('kode_transaksi');
            $table->string('kode');
            $table->string('kategori');
            $table->string('nama');
            $table->integer('quantity');
            $table->decimal('harga_beli', 10,2);
            $table->decimal('harga_jual', 10,2);
            // $table->decimal('total_harga_without_pajak_diskon', 10,2);
            $table->decimal('total_harga', 10,2);
            $table->decimal('total_diskon', 10,2);
            $table->decimal('total_pajak', 10,2);
            $table->string('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_after_checkouts');
    }
};

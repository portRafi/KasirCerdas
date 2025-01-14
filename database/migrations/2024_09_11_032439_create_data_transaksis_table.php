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
        Schema::create('data_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnis_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('cabangs_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('kode_transaksi');
            $table->string('email_staff');
            $table->string('metode_pembayaran');
            $table->decimal('total_harga_beli', 10,2);
            $table->decimal('total_harga_jual', 10,2);
            $table->decimal('total_harga_after_diskon', 10,2);
            $table->decimal('total_harga_after_pajak', 10,2);
            $table->decimal('total_diskon_transaksi', 10,2);
            $table->decimal('total_diskon', 10,2);
            $table->decimal('total_harga', 10,2);
            $table->decimal('total_pajak', 10,2);
            $table->decimal('keuntungan', 10,2);            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_transaksis');
    }
};

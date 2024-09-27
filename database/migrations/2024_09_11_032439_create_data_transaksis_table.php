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
            $table->integer('kode_transaksi');
            $table->string('email_staff');
            $table->date('tanggal');
            $table->string('metode_pembayaran');
            $table->decimal('keuntungan', 10,2);            
            $table->decimal('total_tagihan', 10,2);
            $table->string('label');
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

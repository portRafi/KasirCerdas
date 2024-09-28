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
<<<<<<< HEAD
            $table->string('nama');
            $table->integer('quantity');
            $table->string('pembayaran');
            $table->string('total');
=======
            $table->string('kode_transaksi');
            $table->string('email_staff');
            $table->string('metode_pembayaran');
            $table->decimal('total_harga', 10,2);
            $table->decimal('total_harga_after_pajak', 10,2);
            $table->decimal('keuntungan', 10,2);            
>>>>>>> 7cc6910096c68b47ea7efe8824dd768b685af859
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

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
        Schema::create('data_pembelians', function (Blueprint $table) {
            $table->id();
            $table->integer('id_struk');
            $table->string('email_staff');
            $table->date('tanggal');
            $table->string('tipe_pembayaran');
            $table->integer('diskon');
            $table->integer('pajak');
            $table->decimal('total_tagihan', 10,2);
            $table->decimal('yang_dibayarkan', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pembelians');
    }
};

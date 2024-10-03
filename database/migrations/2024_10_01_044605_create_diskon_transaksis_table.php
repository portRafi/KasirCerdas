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
        Schema::create('diskon_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('bisnis');
            $table->string('cabang');
            $table->string('tipe_diskon');
            $table->string('nama_diskon');
            $table->integer('jumlah_diskon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskon_transaksis');
    }
};

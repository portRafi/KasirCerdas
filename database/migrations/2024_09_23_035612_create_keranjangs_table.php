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
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->integer('userid')->unique();
            $table->string('bisnis');
            $table->string('cabang');
            $table->string('nama');
            $table->string('kategori');
            $table->decimal('harga_beli', 10,2);
            $table->decimal('harga_jual', 10,2);
            $table->decimal('total_harga', 10,2);
            $table->string('kode');
            $table->integer('quantity');
            $table->integer('diskon');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};

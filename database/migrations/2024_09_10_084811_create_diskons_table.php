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
        Schema::create('diskons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnis_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('cabangs_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('tipe_diskon');
            $table->string('nama_diskon');
            $table->integer('jumlah_diskon');
            $table->integer('stok_diskon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diskons');
    }
};

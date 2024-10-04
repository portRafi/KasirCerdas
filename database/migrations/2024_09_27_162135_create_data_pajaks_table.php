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
        Schema::create('data_pajaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bisnis_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('cabangs_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('kode_transaksi');
            $table->decimal('jumlah_pajak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pajaks');
    }
};

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
        Schema::create('items_pembelians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_pembelian');
            $table->string('nama_barang');
            $table->integer('harga_lama');
            $table->integer('harga_baru');
            $table->integer('jumlah_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_pembelians');
    }
};

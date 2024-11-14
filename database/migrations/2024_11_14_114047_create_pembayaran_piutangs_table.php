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
        Schema::create('pembayaran_piutangs', function (Blueprint $table) {
            $table->id();
            $table->string('hutang_id');
            $table->integer('pembayaran ke-');
            $table->integer('jumlah_bayar_pokok');
            $table->integer('jumlah_bayar_bunga');
            $table->date('tanggal_pembayaran');
            $table->timestamps();

            $table->foreign('hutang_id')->references('id')->on('piutangs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_piutangs');
    }
};

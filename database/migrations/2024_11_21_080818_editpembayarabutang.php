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
        Schema::table('pembayaran_piutangs', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('tanggal_pembayaran'); // Sesuaikan nama kolom
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran_piutangs', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};

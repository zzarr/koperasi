<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->date('registered_at')->default(DB::raw('CURRENT_DATE'))->change();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->date('registered_at')->nullable()->change();
    });
}

};

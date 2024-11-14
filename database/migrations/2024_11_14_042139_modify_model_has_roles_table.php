<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyModelHasRolesTable extends Migration
{
    public function up()
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Ubah model_id menjadi UUID
            $table->uuid('model_id')->change();
        });
    }

    public function down()
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Kembalikan ke tipe integer jika ingin rollback
            $table->unsignedBigInteger('model_id')->change();
        });
    }
}

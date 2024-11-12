<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recaps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('month');
            $table->string('year');
            $table->string('in')->nullable();
            $table->string('out')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });

        Schema::create('recap_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('recap_id');
            $table->string('name');
            $table->string('type');
            $table->string('in')->nullable();
            $table->string('out')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('recap_id')->references('id')->on('recaps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recaps');
    }
}

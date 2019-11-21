<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKunciTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuncis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('soal_id');
            $table->foreign('soal_id')->references('id')->on('soals');
            $table->string('kunci_id');
            $table->foreign('kunci_id')->references('id')->on('pilihans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuncis');
    }
}

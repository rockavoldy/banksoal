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
            $table->foreign('soal_id')->references('id')->on('soals')->onDelete('cascade')->onDelete('cascade');
            $table->string('kunci_id');
            $table->foreign('kunci_id')->references('id')->on('pilihans')->onDelete('cascade')->onDelete('cascade');
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

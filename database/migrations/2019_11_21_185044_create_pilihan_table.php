<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilihans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('soal_id');
            $table->foreign('soal_id')->references('id')->on('soals')->onUpdate('cascade')->onDelete('cascade');
            $table->text('pilihan');
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
        Schema::dropIfExists('pilihans');
    }
}

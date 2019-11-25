<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawabans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('users');
            $table->uuid('soal_id');
            $table->foreign('soal_id')->references('id')->on('soals');
            $table->uuid('pilihan_id')->nullable();
            $table->foreign('pilihan_id')->references('id')->on('pilihans');
            $table->text('alasan')->nullable();
            $table->boolean('is_benar');
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
        Schema::dropIfExists('jawabans');
    }
}

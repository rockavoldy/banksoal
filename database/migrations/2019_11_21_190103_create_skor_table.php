<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('users');
            $table->integer('benar')->nullable()->default(0);
            $table->integer('skor')->nullable()->default(0);
            $table->integer('waktu')->nullable()->default(0);
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
        Schema::dropIfExists('skors');
    }
}

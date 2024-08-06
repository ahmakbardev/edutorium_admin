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
        Schema::create('tugas_akhir_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugas_akhir_id');
            $table->unsignedBigInteger('user_id');
            $table->json('kriteria_penilaian');
            $table->timestamps();

            $table->foreign('tugas_akhir_id')->references('id')->on('tugas_akhirs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tugas_akhir_assessments');
    }
};

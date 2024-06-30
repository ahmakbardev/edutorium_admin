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
        Schema::create('tugas_akhirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modul_id');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('deskripsi_pdf')->nullable();
            $table->date('deadline');
            $table->json('kriteria_penilaian');
            $table->timestamps();

            // Ensure foreign key constraints are created after all other columns
            $table->foreign('modul_id')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tugas_akhirs');
    }
};

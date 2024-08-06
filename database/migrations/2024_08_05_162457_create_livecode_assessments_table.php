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
        Schema::create('livecode_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livecode_tutorial_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('kriteria_penilaian'); // [{"kriteria": "baris kode", "nilai": 85}, {"kriteria": "kerapian kode", "nilai": 90}]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('livecode_assessments');
    }
};

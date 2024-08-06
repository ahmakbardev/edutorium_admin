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
        Schema::table('tugas_akhirs', function (Blueprint $table) {
            $table->dropForeign(['modul_id']); // Drop foreign key constraint first
            $table->dropColumn('modul_id'); // Then drop the column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tugas_akhirs', function (Blueprint $table) {
            $table->foreignId('modul_id')->constrained()->onDelete('cascade');
        });
    }
};

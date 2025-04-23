<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('character_play', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('play_id');
            $table->unsignedBigInteger('character_id');
            $table->foreign('play_id')->references('id')->on('plays')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->unique(['play_id', 'character_id']); // Evita duplicados
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_play');
    }
};

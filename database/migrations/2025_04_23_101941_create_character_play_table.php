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

            // FK a plays con borrado en cascada
            $table->foreignId('play_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // FK a characters con borrado en cascada
            $table->foreignId('character_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->timestamps();

            // Evita duplicados
            $table->unique(['play_id', 'character_id']);
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

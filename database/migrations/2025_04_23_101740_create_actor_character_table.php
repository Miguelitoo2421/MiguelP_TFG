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
        Schema::create('actor_characters', function (Blueprint $table) {
            $table->id();

            // Usamos foreignId en lugar de unsignedBigInteger + foreign(), y añadimos cascadeOnDelete
            $table->foreignId('actor_id')
                  ->nullable()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('character_id')
                  ->nullable()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->smallInteger('mastery_level');
            $table->string('notes', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_characters');
    }
};

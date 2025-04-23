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
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->unsignedBigInteger('character_id')->nullable();
            $table->smallInteger('mastery_level');
            $table->string('notes', 255)->nullable();
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->foreign('character_id')->references('id')->on('characters');
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

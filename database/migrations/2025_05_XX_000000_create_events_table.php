<?php

// database/migrations/2025_05_XX_000000_create_events_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // FK a plays
            $table->foreignId('play_id')
                  ->constrained()
                  ->cascadeOnDelete();
            // FK a locations
            $table->foreignId('location_id')
                  ->constrained()
                  ->cascadeOnDelete();
            // Campos propios
            $table->string('title', 100);
            $table->dateTime('scheduled_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
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
        Schema::create('actors', function (Blueprint $table) {
            $table->id();

            // columna de imagen
            $table->string('image', 255)->nullable();

            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 15)->nullable();
            $table->string('email', 30)->nullable();
            $table->string('city', 30)->nullable();

            $table->boolean('has_car')->nullable();
            $table->boolean('can_drive')->nullable();
            $table->boolean('active');

            $table->string('notes', 255)->nullable();

            // borrado suave
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actors');
    }
};

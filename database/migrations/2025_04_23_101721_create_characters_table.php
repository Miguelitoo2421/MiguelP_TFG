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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('notes', 255)->nullable();

            //$table->unsignedBigInteger('play_id')->nullable();
            //$table->foreign('play_id')
                  //->references('id')
                  //->on('plays')
                  //->onDelete('set null');

            // aquí añadimos directamente la columna image
            $table->string('image', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};

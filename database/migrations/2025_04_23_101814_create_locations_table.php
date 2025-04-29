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
        // Si no te importa perder datos en local:
        Schema::dropIfExists('locations');

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            
            // Ciudad sigue siendo obligatorio
            $table->string('city', 50);
            
            // El resto opcional
            $table->string('province',     50)->nullable();
            $table->string('region',       50)->nullable();
            $table->string('street_type',  200)->nullable();
            $table->string('street_name',  200)->nullable();
            $table->string('street_number', 20)->nullable();
            $table->string('postal_code',   20)->nullable();
            
            $table->string('phone',        20)->nullable();
            $table->decimal('latitude',  10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            
            $table->boolean('active');
            $table->string('notes',       255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};

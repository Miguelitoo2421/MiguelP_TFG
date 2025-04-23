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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('city', 30);
            $table->string('province', 30);
            $table->string('region', 30);
            $table->string('street_type', 50);
            $table->string('street_name', 50);
            $table->string('street_number', 10);
            $table->string('postal_code', 5);
            $table->string('url_map', 255)->nullable();
            $table->string('phone', 15)->nullable();
            $table->boolean('active');
            $table->string('notes', 255)->nullable();
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

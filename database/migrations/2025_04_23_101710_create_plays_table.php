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
        Schema::create('plays', function (Blueprint $table) {
            $table->id();
            $table->string('image', 255)->nullable();
            $table->string('name', 50);
            $table->boolean('active');
            $table->string('notes', 255)->nullable();
            $table->unsignedBigInteger('producer_id')->nullable();
            $table->foreign('producer_id')->references('id')->on('producers')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plays');
    }
};

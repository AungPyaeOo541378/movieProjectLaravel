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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->char('title', 100);
            $table->string('image');
            $table->enum('image_type',['poster','mainImage'])->default('mainImage');
            $table->longText('description');
            $table->char('movie_type',20);
            $table->char('director', 100);
            $table->string('rating', 10);
            $table->string('duration', 10);
            $table->string('release_date', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};

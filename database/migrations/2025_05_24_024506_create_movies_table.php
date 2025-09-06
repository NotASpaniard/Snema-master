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
            $table->string("title");
            $table->date("release_date");
            $table->string("poster");
            $table->string("author");
            $table->integer("duration");
            $table->string("language");
            $table->string("caption");
            $table->string("description");
            $table->string("comment");
            $table->double("rating");
            $table->foreignId("genre_movie_id")->constrained("genre_movies");
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

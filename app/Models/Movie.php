<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $table = 'movies';
    protected $fillable = ['title', 'release_date', 'poster', 'author', 'duration', 'language', 'caption', 'description', 'comment', 'rating', 'trailer', 'genre_movie_id'];

    public function destroyMovie() {
        DB::table('movies')
            ->where('id', $this->id)
            ->delete();
    }

    public function genre_movie()
    {
        return $this->belongsTo(GenreMovie::class, 'genre_movie_id');
    }

    public function showtime()
    {
        return $this->hasMany(Showtime::class);
    }

}

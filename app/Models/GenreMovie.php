<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GenreMovie extends Model
{
    /** @use HasFactory<\Database\Factories\GenreMovieFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'genre_id'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}

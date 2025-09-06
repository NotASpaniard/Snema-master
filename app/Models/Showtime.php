<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    /** @use HasFactory<\Database\Factories\ShowtimeFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'start_time', 'end_time', 'price', 'status', 'movie_id', 'room_id'];

    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }
}

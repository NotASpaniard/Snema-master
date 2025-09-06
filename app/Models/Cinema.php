<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cinema extends Model
{
    /** @use HasFactory<\Database\Factories\CinemaFactory> */
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'name', 'email', 'phone_number', 'description', 'location_id'];

    public function rooms() {
        return $this->belongsTo(Room::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function destroyCinema() {
        DB::table('cinemas')
        ->where('id', $this->id)
        ->delete();
    }
}

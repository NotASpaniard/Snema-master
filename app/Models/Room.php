<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = ['id', 'room_number', 'total_seat', 'cinema_id'];
    public $timestamps = false;

    public function cinema() {
        return $this->belongsTo(Cinema::class);
    }

    // Room.php
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

}

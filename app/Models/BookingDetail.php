<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    /** @use HasFactory<\Database\Factories\BookingDetailFactory> */
    use HasFactory;
    protected $fillable = ['id', 'booking_time', 'price', 'seat_id', 'booking_id'];
    public $timestamps = false;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function seat() {
        return $this->belongsTo(Seat::class);
    }
}

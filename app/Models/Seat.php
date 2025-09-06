<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    /** @use HasFactory<\Database\Factories\SeatFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'seat_type', 'seat_code', 'seat_number', 'seat_price', 'seat_status', 'room_id'];

    public function seats() {
        return $this->hasMany(BookingDetail::class);
    }
}

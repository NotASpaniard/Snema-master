<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Snack extends Model
{
    /** @use HasFactory<\Database\Factories\SnackFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'price', 'image', 'status', 'description'];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_snacks')
            ->withPivot('quantity');
    }

    public function destroySnack() {
        DB::table('snacks')
            ->where('id', $this->id)
            ->delete();
    }

}



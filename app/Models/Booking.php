<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'total_price', 'discount_price', 'final_price', 'status', 'payment_id', 'promotion_id', 'showtime_id', 'booking_snacks_id', 'admin_id', 'customer_id'];

// Trong model Booking
    public function payment_options() {
        return $this->belongsTo(PaymentOption::class);
    }

    public function booking_snacks()
    {
        return $this->belongsTo(BookingSnack::class)->withDefault([
            'additional_snacks' => '[]' // Trả về instance rỗng nếu không có
        ]);
    }

    public function booking_details() {
        return $this->hasMany(BookingDetail::class);
    }

    public function customers() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function admins() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function showtime() {
        return $this->belongsTo(Showtime::class, 'showtime_id');
    }

    public function promotion() {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}

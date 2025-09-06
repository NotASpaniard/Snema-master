<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSnack extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'snack_id',
        'quantity',
        'price',
        'total_price',
        'additional_snacks'
    ];

    protected $casts = [
        'additional_snacks' => 'array'
    ];

    public function snack()
    {
        return $this->belongsTo(Snack::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'booking_snacks_id');
    }

    // Helper method để lấy tất cả snacks
    public function getAllSnacks()
    {
        $snacks = [];

        // Lấy thông tin snack chính từ bảng booking_snacks
        if ($this->snack) {
            $snacks[] = [
                'snack_id' => $this->snack_id,
                'quantity' => $this->quantity,
                'total_price' => $this->total_price,
                'name' => $this->snack->name // Sử dụng quan hệ với model Snack
            ];
        }

        // Xử lý additional_snacks nếu có
        if (!empty($this->additional_snacks)) {
            $additional = is_string($this->additional_snacks)
                ? json_decode($this->additional_snacks, true)
                : (array)$this->additional_snacks;

            if (is_array($additional)) {
                foreach ($additional as $item) {
                    if (isset($item['snack_id'])) {
                        $snack = Snack::find($item['snack_id']);
                        if ($snack) {
                            $snacks[] = [
                                'snack_id' => $snack->id,
                                'quantity' => $item['quantity'] ?? 1,
                                'total_price' => $item['total_price'] ?? ($snack->price * ($item['quantity'] ?? 1)),
                                'name' => $snack->name
                            ];
                        }
                    }
                }
            }
        }
        return $snacks;
    }
}

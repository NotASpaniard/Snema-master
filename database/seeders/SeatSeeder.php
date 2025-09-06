<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $rows = ['A', 'B', 'C', 'D', 'E'];
        $cols = 8;
        $seatNumber = 41; // Bằng tổng số ghế đã có trong database + 1

        foreach ($rows as $row) {
            for ($i = 1; $i <= $cols; $i++) {
                $seat_type = in_array($row, ['A', 'B']) ? 'vip' : 'normal';
                $seat_price = ($seat_type === 'vip') ? 50000 : 45000;

                DB::table('seats')->insert([
                    'id' => $seatNumber,
                    'seat_type' => $seat_type,
                    'seat_code' => $row . $i,       // VD: A1, A2,...
                    'seat_number' => $seatNumber,
                    'seat_price' => $seat_price,
                    'seat_status' => '1',
                    'room_id' => 1,
                        // thêm giá
                ]);

                $seatNumber++;
            }
        }
    }
}

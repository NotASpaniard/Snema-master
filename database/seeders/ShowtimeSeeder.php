<?php

namespace Database\Seeders;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowtimeSeeder extends Seeder
{
    public function run():void
    {
        $startTimes = [
            '10:00:00',
            '13:00:00',
            '16:00:00',
            '19:00:00',
            '21:30:00'
        ];

        $movie_id = 2; // ID phim thật trong DB
        $room_id = 2;  // ID phòng thật trong DB

        $movie = Movie::find($movie_id);
        if (!$movie) {
            $this->command->error("Không tìm thấy movie với ID $movie_id");
            return;
        }

        $duration = $movie->duration; // thời lượng phim (phút)

        foreach ($startTimes as $index => $start) {
            $startTime = Carbon::createFromTimeString($start);
            $endTime = $startTime->copy()->addMinutes($duration);

            // Giá vé cao hơn nếu suất chiếu sau 18h
            $price = $startTime->hour >= 18 ? 20000 : 0;

            DB::table('showtimes')->insert([
                'id' => $index + 6, // $index + tổng số showtime đã có trong database + 1
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'price' => $price,
                'status' => '1',
                'movie_id' => $movie_id,
                'room_id' => $room_id,
            ]);
        }

        $this->command->info("Đã seed showtimes thành công cho movie ID $movie_id");
    }
}

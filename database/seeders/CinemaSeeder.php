<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('cinemas')->insert([
            'id' => 1,
            'name' => 'TD Cinema',
            'email' => 'contact@tdcinema.vn',
            'phone_number' => '0909123456',
            'description' => 'Hệ thống rạp TD Cinema – phục vụ trải nghiệm phim chất lượng cao.',
            'location_id' => 1,
        ]);
    }
}

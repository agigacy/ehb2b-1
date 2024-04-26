<?php

namespace Database\Seeders;

use App\Models\Booking;

use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Booking::insert([[
            'id' => '1',
            'tour_id' => '1',
            'user_id' => '1',
            'date' => '2024-10-31',
            'total' => '3800',
            'status' => '1',
            ]
        ]);
    }
}

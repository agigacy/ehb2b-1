<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger;

class PassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Passenger::insert([
            'id' => '1',
            'booking_id' => '1',
            'name' => 'John Doe',
            'passport' => '1234567890',
            'passport_upload' => '1234567890',
            'designation' => 'work',
            'date_of_birth' => '2021-01-01',
            'hp' => '0123456789',
            'remark' => 'got visa',
        ],
        [
            'id' => '2',
            'booking_id' => '1',
            'name' => 'Chan',
            'passport' => '1234567890',
            'passport_upload' => '1234567890',
            'designation' => 'work',
            'date_of_birth' => '2021-01-01',
            'hp' => '0123456789',
            'remark' => 'got visa',
        ]
        [
            'id' => '3',
            'booking_id' => '2',
            'name' => 'Hoang',
            'passport' => '1234567890',
            'passport_upload' => '1234567890',
            'designation' => 'work',
            'date_of_birth' => '2021-01-01',
            'hp' => '0123456789',
            'remark' => 'got visa',
        ]
    );
    }
}

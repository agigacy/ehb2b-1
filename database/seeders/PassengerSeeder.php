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
            [
            'id' => '1',
            'booking_id' => '1',
            'name' => 'John Doe',
            'passport' => 'A9292828',
            'passport_upload' => '',
            'designation' => 'work',
            'date_of_birth' => '1992-01-01',
            'hp' => '0169293923',
            'remark' => 'got visa',
        ],
        [
            'id' => '2',
            'booking_id' => '1',
            'name' => 'Chan',
            'passport' => 'A2139482',
            'passport_upload' => '',
            'designation' => 'work',
            'date_of_birth' => '2002-01-01',
            'hp' => '0140203929',
            'remark' => 'got visa',
        ],
        [
            'id' => '3',
            'booking_id' => '1',
            'name' => 'Hoang',
            'passport' => 'A9482712',
            'passport_upload' => '',
            'designation' => 'work',
            'date_of_birth' => '1999-01-01',
            'hp' => '0138282828',
            'remark' => 'got visa',
        ]
    ]);
    }
}

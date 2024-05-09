<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlobalSetting;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GlobalSetting::insert([
            [
                'id' => 1,
                'key' => 'tour_min_group',
                'value' => '10',
            ],
            [
                'id' => 2,
                'key' => 'booking_first_reminder_day',
                'value' => '1',
            ],
            [
                'id' => 3,
                'key' => 'booking_before_departure_reminder_day',
                'value' => '30',
            ],
            [
                'id' => 4,
                'key' => 'flight_ticket_first_reminder_day',
                'value' => '30',
            ],
            [
                'id' => 5,
                'key' => 'flight_ticket_second_reminder_day',
                'value' => '90',
            ],
            [
                'id' => 6,
                'key' => 'flight_ticket_third_reminder_day',
                'value' => '180',
            ],
            [
                'id' => 7,
                'key' => 'tour_tier_1_people',
                'value' => '10',
            ],
            [
                'id' => 8,
                'key' => 'tour_tier_2_people',
                'value' => '20',
            ],
        ]);
    }
}

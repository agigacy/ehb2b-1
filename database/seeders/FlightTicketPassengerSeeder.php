<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlightTicketPassenger;

class FlightTicketPassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FlightTicketPassenger::insert([
            [
                'flight_ticket_id' => '1',
                'passenger_id' => '1',
            ],
            [
                'flight_ticket_id' => '1',
                'passenger_id' => '2',
            ],
            [
                'flight_ticket_id' => '1',
                'passenger_id' => '3',
            ],
        ]);
    }
}

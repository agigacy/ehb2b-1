<?php

namespace Database\Seeders;

use App\Models\FlightTicket;
use App\Models\Tour;

use Illuminate\Database\Seeder;

class FlightTicketTourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tours = Tour::take(1)->get();

        FlightTicket::all()->each(function ($flight_ticket) use ($tours) {
            $flight_ticket->tours()->attach(
                $tours->random(1)->pluck('id')                
            );
        });
    }
}

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
    // public function run()
    // {
    //     $tours = Tour::take(1)->get();

    //     FlightTicket::all()->each(function ($flight_ticket) use ($tours) {
    //         $flight_ticket->tours()->attach(
    //             $tours->random(1)->pluck('id')                
    //         );
    //     });
    // }
    public function run()
    {
        // 获取所有的 Tours
        $tours = Tour::all();

        // 指定 FlightTicket 与 Tour 的关联
        $flightTicketsTours = [
            ['tickets' => [1, 2], 'tourId' => 1],
            ['tickets' => [3, 4], 'tourId' => 2],
            ['tickets' => [5, 6], 'tourId' => 3],
            ['tickets' => [7, 8], 'tourId' => 4]
        ];

        foreach ($flightTicketsTours as $item) {
            foreach ($item['tickets'] as $flightTicketId) {
                $flightTicket = FlightTicket::find($flightTicketId);
                if ($flightTicket) {
                    $flightTicket->tours()->attach($item['tourId']);
                }
            }
        }
    }
}

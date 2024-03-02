<?php

namespace Database\Seeders;

use App\Models\FlightTicket;

use Illuminate\Database\Seeder;

class FlightTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FlightTicket::insert([[
            'id' => '1',
            'pnr' => 'KSDSNW',
            'airline' => 'Airasia',
            'departure_date' => '2023-12-31 12:13:00',
            'return_date' => '2024-1-03 12:13:00',
            'from' => 'KUL',
            'to' => 'NRT',
            'seat' => '10',
        ],
        [
            'id' => '2',
            'pnr' => 'OEJEND',
            'airline' => 'Airasia',
            'departure_date' => '2023-12-31 12:13:00',
            'return_date' => '2024-1-03 12:13:00',
            'from' => 'KUL',
            'to' => 'NRT',
            'seat' => '5',
        ]
        ]);
    }
}

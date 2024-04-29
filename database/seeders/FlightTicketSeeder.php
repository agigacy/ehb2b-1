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
            'departure_date' => '2024-12-31 12:13:00',
            'return_date' => '2025-01-03 12:13:00',
            'from' => 'KUL',
            'to' => 'NRT',
            'seat' => '10',
        ],
        [
            'id' => '2',
            'pnr' => 'OEJEND',
            'airline' => 'Airasia',
            'departure_date' => '2024-12-31 12:13:00',
            'return_date' => '2025-01-03 12:13:00',
            'from' => 'KUL',
            'to' => 'NRT',
            'seat' => '5',
        ],
        [
            'id' => '3',
            'pnr' => 'JDKSDS',
            'airline' => 'Airasia',
            'departure_date' => '2025-03-01 12:13:00',
            'return_date' => '2025-03-06 12:13:00',
            'from' => 'KUL',
            'to' => 'TPE',
            'seat' => '10',
        ],
        [
            'id' => '4',
            'pnr' => 'PERMDS',
            'airline' => 'Airasia',
            'departure_date' => '2025-03-01 12:13:00',
            'return_date' => '2025-03-06 12:13:00',
            'from' => 'KUL',
            'to' => 'TPE',
            'seat' => '10',
        ],
        [
            'id' => '5',
            'pnr' => 'MDKSMW',
            'airline' => 'Airasia',
            'departure_date' => '2025-04-01 12:13:00',
            'return_date' => '2025-04-10 12:13:00',
            'from' => 'KUL',
            'to' => 'AKL',
            'seat' => '10',
        ],
        [
            'id' => '6',
            'pnr' => 'OWMDNS',
            'airline' => 'Airasia',
            'departure_date' => '2025-04-01 12:13:00',
            'return_date' => '2025-04-10 12:13:00',
            'from' => 'KUL',
            'to' => 'AKL',
            'seat' => '10',
        ],
        [
            'id' => '7',
            'pnr' => 'IWMJSS',
            'airline' => 'Airasia',
            'departure_date' => '2025-06-01 12:13:00',
            'return_date' => '2025-06-04 12:13:00',
            'from' => 'KUL',
            'to' => 'HKG',
            'seat' => '10',
        ],
        [
            'id' => '8',
            'pnr' => 'EJSMN',
            'airline' => 'Airasia',
            'departure_date' => '2025-06-01 12:13:00',
            'return_date' => '2025-06-04 12:13:00',
            'from' => 'KUL',
            'to' => 'HKG',
            'seat' => '10',
        ]
        ]);
    }
}

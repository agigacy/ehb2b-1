<?php

namespace Database\Seeders;

use App\Models\Tour;

use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tour::insert([[
            'id' => '1',
            'package_name' => '4D3N Tokyo, Mt Fuji & Hakone Tour',
            'package_name_chinese' => '4D3N Tokyo, Mt Fuji & Hakone Tour',
            'airline' => 'Airasia',
            'code' => '20231231JTMHT',
            'departure_date' => '2023-12-31 12:13:00',
            'return_date' => '2024-1-03 12:13:00',
            'tier1' => '2500',
            'tier2' => '2700',
            'tier3' => '3000',
            'tier1_c' => '50',
            'tier2_c' => '100',
            'tier3_c' => '150',
            'country_id' => '1',
            'min_g' => '10',
            'remark' => 'Visit Tokyo, Osaka, Nagoya, Fukuoka, Okinawa, Tottori, Hakone, Kanazawa, Abril and more',
            ]
        ]);
    }
}

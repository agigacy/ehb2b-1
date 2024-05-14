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
            'tour_group_id' => '1',
            // 'package_name' => '4D3N Tokyo, Mt Fuji & Hakone Tour',
            // 'package_name_chinese' => '4D3N Tokyo, Mt Fuji & Hakone Tour',
            'airline' => 'Airasia',
            'code' => '20231231JTMHT',
            'departure_date' => '2023-12-31 12:13:00',
            'return_date' => '2024-01-03 12:13:00',
            'tier1' => '2500',
            'tier2' => '2700',
            'tier3' => '3000',
            'tier1_c' => '50',
            'tier2_c' => '100',
            'tier3_c' => '150',
            // 'country_id' => '1',
            'min_g' => '10',
            'remark' => 'Visit Tokyo, Osaka, Nagoya, Fukuoka, Okinawa, Tottori, Hakone, Kanazawa, Abril and more',
        ],
        [
            'id' => '2',
            'tour_group_id' => '2',
            // 'package_name' => '5D4N Taiwan Taipei + Yilan',
            // 'package_name_chinese' => '5D4N Taiwan Taipei + Yilan',
            'airline' => 'Airasia',
            'code' => '20240229TWTYL',
            'departure_date' => '2025-03-01 12:13:00',
            'return_date' => '2025-03-06 12:13:00',
            'tier1' => '2500',
            'tier2' => '2700',
            'tier3' => '3000',
            'tier1_c' => '50',
            'tier2_c' => '100',
            'tier3_c' => '150',
            // 'country_id' => '2',
            'min_g' => '10',
            'remark' => 'Visit Taipei, Yilan, Taiwan',
        ],
        [
            'id' => '3',
            'tour_group_id' => '3',
            // 'package_name' => '10D9N MIGHTY NEW ZEALAND (AUCKLAND/CHRISTCHURCH)',
            // 'package_name_chinese' => '10D9N MIGHTY NEW ZEALAND (AUCKLAND/CHRISTCHURCH)',
            'airline' => 'Airasia',
            'code' => '20250229',
            'departure_date' => '2025-04-01 12:13:00',
            'return_date' => '2025-04-10 12:13:00',
            'tier1' => '31000',
            'tier2' => '33000',
            'tier3' => '35000',
            'tier1_c' => '150',
            'tier2_c' => '300',
            'tier3_c' => '500',
            // 'country_id' => '3',
            'min_g' => '10',
            'remark' => 'Visit Auckland, Christchurch, New Zealand',
        ],
        [
            'id' => '4',
            'tour_group_id' => '4',
            // 'package_name' => '4D3N Hong Kong Disneyland Family & Fun',
            // 'package_name_chinese' => '4D3N Hong Kong Disneyland Family & Fun',
            'airline' => 'Airasia',
            'code' => '20250229HKDL',
            'departure_date' => '2025-06-01 12:13:00',
            'return_date' => '2025-06-04 12:13:00',
            'tier1' => '23000',
            'tier2' => '25000',
            'tier3' => '27000',
            'tier1_c' => '150',
            'tier2_c' => '300',
            'tier3_c' => '500',
            // 'country_id' => '4',
            'min_g' => '10',
            'remark' => 'Visit Hong Kong Disneyland Family & Fun',
        ]
        ]);
    }
}

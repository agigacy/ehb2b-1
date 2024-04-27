<?php

namespace Database\Seeders;

use App\Models\Country;

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::insert([[
            'id' => '1',
            'name' => 'Japan',
            'img_url' => 'https://www.worldometers.info/img/flags/ja-flag.gif'
        ],
        [
            'id' => '2',
            'name' => 'Taiwan',
            'img_url' => 'https://www.worldometers.info/img/flags/tw-flag.gif'
        ],
        [
            'id' => '3',
            'name' => 'New Zealand',
            'img_url' => 'https://www.worldometers.info/img/flags/nz-flag.gif'
        ],
        [
            'id' => '4',
            'name' => 'Hong Kong',
            'img_url' => 'https://www.worldometers.info/img/flags/hk-flag.gif'
        ]
        ]);
    }
}

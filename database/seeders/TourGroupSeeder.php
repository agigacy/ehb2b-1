<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TourGroup;

class TourGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TourGroup::insert([
            [
                'id' => '1',
                'country_id' => '1',
                'tour_group_name' => '4D3N Tokyo, Mt Fuji & Hakone Tour',
                'tour_group_name_chinese' => '4D3N Tokyo, Mt Fuji & Hakone Tour',
                'tour_img_url' => 'https://a.cdn-hotels.com/gdcs/production172/d1381/8efd3f69-63bb-4398-a595-095cea25fc37.jpg',
            ],
            [
                'id' => '2',
                'country_id' => '2',
                'tour_group_name' => '5D4N Taiwan Taipei + Yilan',
                'tour_group_name_chinese' => '5D4N Taiwan Taipei + Yilan',
                'tour_img_url' => 'https://www.amitravel.my/wp-content/uploads/2020/02/taipei-taiwan-2057818_1920.jpg',
            ],
            [
                'id' => '3',
                'country_id' => '3',
                'tour_group_name' => '10D9N MIGHTY NEW ZEALAND (AUCKLAND/CHRISTCHURCH)',
                'tour_group_name_chinese' => '10D9N MIGHTY NEW ZEALAND (AUCKLAND/CHRISTCHURCH)',
                'tour_img_url' => 'https://dynastytravel.com.sg/wp-content/uploads/2023/04/christchurch-new-zealand-1800x1000-1.jpg',
            ],
            [
                'id' => '4',
                'country_id' => '4',
                'tour_group_name' => '4D3N Hong Kong Disneyland Family & Fun',
                'tour_group_name_chinese' => '4D3N Hong Kong Disneyland Family & Fun',
                'tour_img_url' => 'https://res.klook.com/image/upload/fl_lossy.progressive,q_85/c_fill,w_680/v1693387968/neao3yydd9xnunl8qj2i.jpg',
            ],
        ]);
    }
}

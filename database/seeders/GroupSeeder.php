<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\User;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 创建一个组
        $group1 = Group::create(['name' => 'Esplanad Holiday Sdn Bhd','ssm_number' => '22020313', 'address' => '79-2, Jalan Dwitasik 1, Dataran Dwitasik, 56000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 'phone' => '016-666 2238', 'email' => 'eh@esplanad.com.my', 'website' => 'http://www.esplanad.com.my/', 'tier1' => '1', 'tier2' => '1', 'tier3' => '1']);
        $group2 = Group::create(['name' => 'Pearl Holiday (M) Travel & Tour Sdn Bhd','ssm_number' => '30202012', 'address' => '1, Jalan KP 1/3, Taman Kajang Prima, 43000 Kajang, Selangor', 'phone' => '06-333 8888', 'email' => 'pearl@pearl.com', 'website' => 'https://www.pearlholiday.com/', 'tier1' => '0', 'tier2' => '1', 'tier3' => '1']);
        $group3 = Group::create(['name' => 'Reliance Premier Travel Malaysia','ssm_number' => '50403012', 'address' => '46C Jalan Suarasa 8/4, Bandar Tun Hussein Onn, Cheras Batu 9 Cheras, 43200 Kuala Lumpur, Selangor', 'phone' => '03-9074 8699', 'email' => 'reliance@reliance.com', 'website' => 'https://www.reliancepremiertravel.com/', 'tier1' => '0', 'tier2' => '0', 'tier3' => '1']);
        $group4 = Group::create(['name' => 'MATTA FAIR SECRETARIAT','ssm_number' => '10220313', 'address' => 'No 6, Jalan Metro Pudu 2, Fraser Business Park, 55100 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 'phone' => '03-9222 1155', 'email' => 'matta@matta.com', 'website' => 'https://www.mattafair.com/', 'tier1' => '0', 'tier2' => '0', 'tier3' => '0', 'sp' => '1']);

        // 找到要分配的用户
        $user1 = User::find(1);
        $user2 = User::find(2);
        $user3 = User::find(3);
        $user4 = User::find(4);

        // 将这个组分配给这两个用户
        $group1->users()->attach([$user1->id]);
        $group2->users()->attach([$user2->id]);
        $group3->users()->attach([$user3->id]);
        $group4->users()->attach([$user4->id]);
    }
}

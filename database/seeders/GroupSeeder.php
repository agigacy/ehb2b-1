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
        $group = Group::create(['name' => 'EH', 'tier1' => '1', 'tier2' => '1', 'tier3' => '1']);

        // 找到要分配的用户
        $user1 = User::find(1);
        $user2 = User::find(2);

        // 将这个组分配给这两个用户
        $group->users()->attach([$user1->id, $user2->id]);
    }
}

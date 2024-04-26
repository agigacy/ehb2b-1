<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
            'id' => '1',
            'name' => 'cy',
            'email' => 'cy@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
            [
            'id' => '2',
            'name' => 'antoney',
            'email' => 'antoney@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
        ]);
    }
}

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
            [
            'id' => '3',
            'name' => 'mlchan',
            'email' => 'mlchan@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
            [
            'id' => '4',
            'name' => 'ian',
            'email' => 'ian@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
            [
            'id' => '5',
            'name' => 'john',
            'email' => 'john@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
            [
            'id' => '6',
            'name' => 'jane',
            'email' => 'jane@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
            [
            'id' => '7',
            'name' => 'mike',
            'email' => 'mike@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
            [
            'id' => '8',
            'name' => 'johnson',
            'email' => 'johnson@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
            [
            'id' => '9',
            'name' => 'davis',
            'email' => 'davis@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ],
            [
            'id' => '10',
            'name' => 'taylor',
            'email' => 'taylor@thebeanz.com.my',
            'password' => '$2y$10$6n9xLvBgqTEZg61IXIp1AOEFc6czyR4nE8Qu7nNZVJKt3QVFHLi4y',
            ]
        ]);
    }
}

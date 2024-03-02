<?php

namespace Database\Seeders;

use App\Models\FlightTicket;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(TourSeeder::class);
        $this->call(FlightTicketSeeder::class);
        $this->call(FlightTicketTourSeeder::class);
        $this->call(BookingSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use App\Models\FlightTicket;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        $this->call(TourGroupSeeder::class);
        $this->call(TourSeeder::class);
        $this->call(FlightTicketSeeder::class);
        $this->call(FlightTicketTourSeeder::class);
        $this->call(BookingSeeder::class);
        $this->call(PassengerSeeder::class);
        $this->call(FlightTicketPassengerSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(GlobalSettingSeeder::class);
        
        // $role = Role::create(['name' => 'admin']);
        // $permission = Permission::create(['name' => 'edit articles']);
        // $role->givePermissionTo($permission);
    }
}

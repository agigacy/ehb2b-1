<?php


namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         // create permissions
         Permission::create(['name' => 'admin_page_view']);
         Permission::create(['name' => 'admin_page_create']);
         Permission::create(['name' => 'admin_page_edit']);
         Permission::create(['name' => 'admin_page_delete']);
         Permission::create(['name' => 'user_view']);
         Permission::create(['name' => 'user_create']);
         Permission::create(['name' => 'user_edit']);
         Permission::create(['name' => 'user_delete']);
         Permission::create(['name' => 'group_view']);
         Permission::create(['name' => 'group_create']);
         Permission::create(['name' => 'group_edit']);
         Permission::create(['name' => 'group_delete']);
         Permission::create(['name' => 'role_view']);
         Permission::create(['name' => 'role_create']);
         Permission::create(['name' => 'role_edit']);
         Permission::create(['name' => 'role_delete']);
         Permission::create(['name' => 'permission_view']);
         Permission::create(['name' => 'permission_edit']);
         Permission::create(['name' => 'permission_assign']);
         Permission::create(['name' => 'country_view']);
         Permission::create(['name' => 'country_create']);
         Permission::create(['name' => 'country_edit']);
         Permission::create(['name' => 'country_delete']);
         Permission::create(['name' => 'flight_ticket_view']);
         Permission::create(['name' => 'flight_ticket_create']);
         Permission::create(['name' => 'flight_ticket_edit']);
         Permission::create(['name' => 'flight_ticket_delete']);
         Permission::create(['name' => 'tour_view']);
         Permission::create(['name' => 'tour_create']);
         Permission::create(['name' => 'tour_edit']);
         Permission::create(['name' => 'tour_delete']);
         Permission::create(['name' => 'agent_page_view']);
         Permission::create(['name' => 'agent_page_create']);
         Permission::create(['name' => 'agent_page_edit']);
         Permission::create(['name' => 'agent_page_delete']);
         Permission::create(['name' => 'booking_view']);
         Permission::create(['name' => 'booking_create']);
         Permission::create(['name' => 'booking_edit']);
         Permission::create(['name' => 'booking_delete']);
         Permission::create(['name' => 'report_page_view']);
         Permission::create(['name' => 'report_page_generate']);
         
 
         // create roles and assign created permissions
 
         // this can be done as separate statements
        //  $role = Role::create(['name' => 'writer']);
        //  $role->givePermissionTo('edit articles');
 
         // or may be done by chaining
        //  $role = Role::create(['name' => 'moderator'])
        //      ->givePermissionTo(['publish articles', 'unpublish articles']);
 
         $role = Role::create(['name' => 'super-admin']);
         $adminrole = Role::create(['name' => 'admin']);
         $staffrole = Role::create(['name' => 'staff']);
         $agentrole = Role::create(['name' => 'agent']);
         $role->givePermissionTo(Permission::all());
        //  $role->givePermissionTo(User::find(1));
         
         $user1 = User::find(1);
         $user2 = User::find(2);
         $user3 = User::find(3);
         $user4 = User::find(4);
         $user5 = User::find(5);
         $user6 = User::find(6);
         $user7 = User::find(7);
         $user1->assignRole('super-admin');
         $user2->assignRole('super-admin');
         $user3->assignRole('super-admin');
         $user4->assignRole('super-admin');
         $user5->assignRole('admin');
         $user6->assignRole('staff');
         $user7->assignRole('agent');
        //  $user->givePermissionTo($role);
    }
}

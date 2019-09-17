<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        DB::table('role_user')->truncate();
        DB::table('event')->truncate();
        DB::table('event_runners')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::create([
          'name' => 'Admin',
          'email' => 'admin@admin.com',
          'phone' => '01111385109',
          'password' => bcrypt('admin'),
          'text_pass' => 'admin'

        ]);

        $user = User::create([
          'name' => 'User',
          'email' => 'user@user.com',
          'phone' => '01111385109',
          'password' =>  bcrypt('user'),
          'text_pass' => 'user'
        ]);


        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}

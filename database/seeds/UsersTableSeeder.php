<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role' => 1, // 1 : Owner , 2: Manager
            'name' => "Mr. Owner",
            'email' => "owner@gmail.com",
            'status' => 1,
            'is_active' => 1,
            'password' => bcrypt("12345678"),
        ]);

        
    }
}

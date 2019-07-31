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
            'name' => 'yohan',
            'email' => 'cepoangkuningan@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'role' => '0'
        ]);
    }
}

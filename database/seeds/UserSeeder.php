<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Dicki Prasetya',
            'username' => 'evairo176',
            'email' => 'semenjakpetang176@gmail.com',
            'password' => bcrypt('juara123'),
            'email_verified_at' => Carbon::now(),
            'roles' => 'Admin'
        ]);
        $user = User::create([
            'name' => 'Fandi',
            'username' => 'fandi123',
            'email' => 'fandi@gmail.com',
            'password' => bcrypt('juara123'),
            'email_verified_at' => Carbon::now(),
            'roles' => 'User'
        ]);
    }
}

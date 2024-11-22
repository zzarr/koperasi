<?php

namespace Database\Seeders;

use App\Models\ConfigPayment;
use App\Models\MainPayment;
use App\Models\Roles;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        $user2 = User::create([
            'id' => Str::uuid(), // Set UUID manually
            'name' => 'User 2',
            'username' => 'user2',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('User2#123'),
            'phone_number' => '081234567892',
            'registered_at' => now()
        ]);

        $user2->assignRole('user');
    }
}

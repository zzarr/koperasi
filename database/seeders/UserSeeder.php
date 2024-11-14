<?php

namespace Database\Seeders;

use App\Models\ConfigPayment;
use App\Models\MainPayment;
use App\Models\Roles;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $main_amount = new ConfigPayment();
        // $main_amount->name = 'main_payment';
        // $main_amount->paid_off_amount = 500000;
        // $main_amount->save();

        // $main_amount = new ConfigPayment();
        // $main_amount->name = 'monthly_payment';
        // $main_amount->paid_off_amount = 50000;
        // $main_amount->save();

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin#123'),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User 1',
            'email' => 'user@gmail.com',
            'password' => Hash::make('User#123'),
        ]);

        $user->assignRole('user');
    }
}

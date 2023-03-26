<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jason Stewart',
            'email' => 'jsjazzau@gmail.com',
            'email_verified_at' => now(),
            'password' => null,
            'remember_token' => null,
            'stripe_id' => null,
            'pm_type' => null,
            'pm_last_four' => null,
            'trial_ends_at' => null,
            'provider_id' => '112498862574222639165',
            'provider' => 'google',
        ]);

        User::create([
            'name' => 'Jason Stewart',
            'email' => 'jason@oakdragon.com.au',
            'email_verified_at' => now(),
            'password' => bcrypt('cowcow70'),
            'remember_token' => null,
            'stripe_id' => null,
            'pm_type' => null,
            'pm_last_four' => null,
            'trial_ends_at' => null,
            'provider_id' => null,
            'provider' => null,
        ]);
    }
}

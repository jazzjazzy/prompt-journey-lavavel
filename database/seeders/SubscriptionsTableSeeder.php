<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::create(
            ['user_id' => 1,
                'name' => '4',
                'stripe_id' => 'sub_1Mpk73CohdRQHIZsFm4MWSe5',
                'stripe_status' => 'active',
                'stripe_price' => 'price_1ModfXCohdRQHIZsOj5KgE0s',
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ]
        );
    }
}

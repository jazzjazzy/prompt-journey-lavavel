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
                'name' => 'Monthly Pro Plan',
                'stripe_id' => 'sub_1N2ixICohdRQHIZs7aay4eFB',
                'stripe_status' => 'active',
                'stripe_price' => 'price_1N27E8CohdRQHIZsKlikB3AK',
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ]
        );

        Subscription::create(
            ['user_id' => 5,
                'name' => 'Monthly User Plan',
                'stripe_id' => 'sub_1N5IeYCohdRQHIZsdsX1CTk8',
                'stripe_status' => 'active',
                'stripe_price' => 'price_1N27COCohdRQHIZsul01VrGM',
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ]
        );

        Subscription::create(
            ['user_id' => 6,
                'name' => 'Monthly Pro Plan',
                'stripe_id' => 'sub_1N5IfzCohdRQHIZswYZxrEwJ',
                'stripe_status' => 'active',
                'stripe_price' => 'price_1N27E8CohdRQHIZsKlikB3AK',
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ]
        );

        Subscription::create(
            ['user_id' => 4,
                'name' => 'Tester Plan',
                'stripe_id' => 'one-time-payment-4',
                'stripe_status' => 'active',
                'stripe_price' => 'price_1N2mzdCohdRQHIZssbEROkcA',
                'quantity' => 1,
                'trial_ends_at' => date('Y-m-d h:i:s', strtotime('+1 month', strtotime('-3 days', strtotime(now())))),
                'ends_at' => null,
            ]
        );
    }
}

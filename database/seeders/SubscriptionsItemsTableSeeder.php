<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionItem;

class SubscriptionsItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubscriptionItem::create(
            ['subscription_id' => 1,
                'stripe_id' => 'si_Navzhl4zhPcNE2',
                'stripe_product' => 'prod_NZnGTaAl2UpzGP',
                'stripe_price' => 'price_1ModfXCohdRQHIZsOj5KgE0s',
                'quantity' => 1,
            ]
        );
    }
}

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

        SubscriptionItem::create(
            ['subscription_id' => 2,
                'stripe_id' => 'si_Nr0flBcTojxdPS',
                'stripe_product' => 'prod_NnidOvC03zn7S8',
                'stripe_price' => 'price_1N27COCohdRQHIZsul01VrGM',
                'quantity' => 1,
            ]
        );

        SubscriptionItem::create(
            ['subscription_id' => 3,
                'stripe_id' => 'si_Nr0hPXdxiCsFt4',
                'stripe_product' => 'prod_NnifThGKViHCUl',
                'stripe_price' => 'price_1N27E8CohdRQHIZsKlikB3AK',
                'quantity' => 1,
            ]
        );
    }
}

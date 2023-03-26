<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Free',
            'slug' => 'free',
            'stripe_name' => 'Free',
            'stripe_id' => 'free',
            'price' => 0,
            'abbreviation' => '',
            'description' => 'Free plan',
            'metaData' =>json_encode([
                ['checked' => 'true', 'text' => 'Access to Prompt journey'],
                ['checked' => 'false', 'text' => 'Save prompts'],
                ['checked' => 'false', 'text' => 'Access to project'],
                ['checked' => 'false', 'text' => 'Access to gallery']
            ])
        ]);

        Plan::create(['name' => 'Tester',
            'slug' => 'tester',
            'stripe_name' => 'Tester Plan',
            'stripe_id' => 'price_1ModjXCohdRQHIZsr8HTCGCI',
            'price' => 3,
            'abbreviation' => 'Test',
            'description' => 'Tester plan for testing for 1 month',
            'metaData' =>json_encode([
                ['checked' => 'true', 'text' => 'Access to Prompt journey'],
                ['checked' => 'true', 'text' => 'Save prompts'],
                ['checked' => 'true', 'text' => 'Access 1 project'],
                ['checked' => 'false', 'text' => 'Access to gallery']
            ])
        ]);

        Plan::create(['name' => 'Monthly User',
            'slug' => 'monthly-user',
            'stripe_name' => 'Monthly User Plan',
            'stripe_id' => 'price_1Modj3CohdRQHIZsMWUIHpEp',
            'price' => 3,
            'abbreviation' => '/Month',
            'description' => 'Monthly user account, access to 10 projects',
            'metaData' =>json_encode([
                ['checked' => 'true', 'text' => 'Access to Prompt journey'],
                ['checked' => 'true', 'text' => 'Save prompts'],
                ['checked' => 'true', 'text' => 'Access 10 projects'],
                ['checked' => 'false', 'text' => 'Access to gallery']
            ])
        ]);

        Plan::create(['name' => 'Monthly Pro',
            'slug' => 'monthly-pro',
            'stripe_name' => 'Monthly Pro Plan',
            'stripe_id' => 'price_1ModfXCohdRQHIZsOj5KgE0s',
            'price' => 6,
            'abbreviation' => '/Month',
            'description' => 'Monthly Pro account, access to Unlimited projects',
            'metaData' =>json_encode([
                ['checked' => 'true', 'text' => 'Access to Prompt journey'],
                ['checked' => 'true', 'text' => 'Save prompts'],
                ['checked' => 'true', 'text' => 'Access unlimited projects'],
                ['checked' => 'true', 'text' => 'Access to gallery']
            ])
        ]);
        Plan::create(['name' => 'Yearly User',
            'slug' => 'Yearly-user',
            'stripe_name' => 'Yearly User Plan',
            'stripe_id' => 'price_1Modl4CohdRQHIZsRGT5jajU',
            'price' => 33,
            'abbreviation' => '/Year',
            'description' => 'Yearly user account, access to 10 projects',
            'metaData' =>json_encode([
                ['checked' => 'true', 'text' => 'Access to Prompt journey'],
                ['checked' => 'true', 'text' => 'Save prompts'],
                ['checked' => 'true', 'text' => 'Access 10 projects'],
                ['checked' => 'false', 'text' => 'Access to gallery']
            ])
        ]);

        Plan::create(['name' => 'Yearly Pro',
            'slug' => 'Yearly-pro',
            'stripe_name' => 'Yearly Pro Plan',
            'stripe_id' => 'price_1ModkCCohdRQHIZsKFSZ4Rxw',
            'price' => 6,
            'abbreviation' => '/Year',
            'description' => 'Yearly Pro account, access to Unlimited projects',
            'metaData' =>json_encode([
                ['checked' => 'true', 'text' => 'Access to Prompt journey'],
                ['checked' => 'true', 'text' => 'Save prompts'],
                ['checked' => 'true', 'text' => 'Access unlimited projects'],
                ['checked' => 'true', 'text' => 'Access to gallery']
            ])
        ]);
    }
}

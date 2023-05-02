<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Plan;
use App\Casts\PriceCast;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('stripe_name');
            $table->string('stripe_id');
            $table->bigInteger('price');
            $table->string('abbreviation');
            $table->text('description');
            $table->text('metaData');
            $table->timestamps();
        });

        // populate the plans table
        $plan = new Plan;
        $plan->name = 'Free';
        $plan->slug = 'free';
        $plan->stripe_name = 'Free';
        $plan->stripe_id = 'free';
        $plan->price = 0;
        $plan->abbreviation = '';
        $plan->description = 'Free plan';
        $plan->metaData = json_encode([
            ['checked' => 'true', 'text' => 'Access to Prompt journey'],
            ['checked' => 'false', 'text' => 'Save prompts'],
            ['checked' => 'false', 'text' => 'Access to projects'],
            ['checked' => 'false', 'text' => 'Access to image gallery'],
            ['checked' => 'false', 'text' => 'Access to Suffix List']
        ]);
        $plan->save();

        $plan = new Plan;
        $plan->name = 'Tester';
        $plan->slug = 'tester';
        $plan->stripe_name = 'Tester Plan';
        $plan->stripe_id = 'price_1N2mzdCohdRQHIZssbEROkcA';
        $plan->price = 3;
        $plan->abbreviation = 'Test';
        $plan->description = 'You will only be changed for one single month, account is deleted unless you upgrade';
        $plan->metaData = json_encode([
            ['checked' => 'true', 'text' => 'Access to Prompt journey'],
            ['checked' => 'true', 'text' => 'Save prompts'],
            ['checked' => 'true', 'text' => 'Access 1 project'],
            ['checked' => 'false', 'text' => 'Access to image gallery'],
            ['checked' => 'false', 'text' => 'Access to Suffix List']
        ]);
        $plan->save();

        $plan = new Plan;
        $plan->name = 'Monthly User';
        $plan->slug = 'monthly-user';
        $plan->stripe_name = 'Monthly User Plan';
        $plan->stripe_id = 'price_1N27COCohdRQHIZsul01VrGM';
        $plan->price = 3;
        $plan->abbreviation = '/Month';
        $plan->description = 'Monthly user account, access to 10 projects';
        $plan->metaData = json_encode([
            ['checked' => 'true', 'text' => 'Access to Prompt journey'],
            ['checked' => 'true', 'text' => 'Save prompts'],
            ['checked' => 'true', 'text' => 'Access 10 projects'],
            ['checked' => 'false', 'text' => 'Access to image gallery'],
            ['checked' => 'false', 'text' => 'Access to Suffix List']
        ]);
        $plan->save();

        $plan = new Plan;
        $plan->name = 'Monthly Pro';
        $plan->slug = 'monthly-pro';
        $plan->stripe_name = 'Monthly Pro Plan';
        $plan->stripe_id = 'price_1N27E8CohdRQHIZsKlikB3AK';
        $plan->price = 6;
        $plan->abbreviation = '/Month';
        $plan->description = 'Monthly Pro account, access to Unlimited projects';
        $plan->metaData = json_encode([
            ['checked' => 'true', 'text' => 'Access to Prompt journey'],
            ['checked' => 'true', 'text' => 'Save prompts'],
            ['checked' => 'true', 'text' => 'Access unlimited projects'],
            ['checked' => 'true', 'text' => 'Access to image gallery'],
            ['checked' => 'true', 'text' => 'Access to Suffix List']
        ]);
        $plan->save();

        $plan = new Plan;
        $plan->name = 'Yearly User';
        $plan->slug = 'Yearly-user';
        $plan->stripe_name = 'Yearly User Plan';
        $plan->stripe_id = 'price_1N27DHCohdRQHIZscuc0DgJB';
        $plan->price = 33;
        $plan->abbreviation = '/Year';
        $plan->description = 'Yearly user account, access to 10 projects';
        $plan->metaData = json_encode([
            ['checked' => 'true', 'text' => 'Access to Prompt journey'],
            ['checked' => 'true', 'text' => 'Save prompts'],
            ['checked' => 'true', 'text' => 'Access 10 projects'],
            ['checked' => 'false', 'text' => 'Access to image gallery'],
            ['checked' => 'false', 'text' => 'Access to Suffix List']
        ]);
        $plan->save();

        $plan = new Plan;
        $plan->name = 'Yearly Pro';
        $plan->slug = 'Yearly-pro';
        $plan->stripe_name = 'Yearly Pro Plan';
        $plan->stripe_id = 'price_1N27FDCohdRQHIZsaMgONDPB';
        $plan->price = 66;
        $plan->abbreviation = '/Year';
        $plan->description = 'Yearly Pro account, access to Unlimited projects';
        $plan->metaData = json_encode([
            ['checked' => 'true', 'text' => 'Access to Prompt journey'],
            ['checked' => 'true', 'text' => 'Save prompts'],
            ['checked' => 'true', 'text' => 'Access unlimited projects'],
            ['checked' => 'true', 'text' => 'Access to image gallery'],
            ['checked' => 'true', 'text' => 'Access to Suffix List']
        ]);
        $plan->save();
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

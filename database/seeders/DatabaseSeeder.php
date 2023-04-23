<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UserTableSeeder::class]);
        $this->call([SubscriptionsTableSeeder::class]);
        $this->call([SubscriptionsItemsTableSeeder::class]);
        $this->call([projectsTableSeeder::class]);
        $this->call([ImagesTableSeeder::class]);
        $this->call([GroupsTableSeeder::class]);
        $this->call([ImageGroupTableSeeder::class]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

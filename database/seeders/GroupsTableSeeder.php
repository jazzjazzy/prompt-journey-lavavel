<?php

namespace Database\Seeders;

use App\Models\Groups;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Groups::create([
            'name' => 'Receptionist',
            'type' => 'Image',
            'user_id' => '1',
        ]);

        Groups::create([
            'name' => 'Receptionist v2',
            'type' => 'Image',
            'user_id' => '1',
        ]);

        Groups::create([
            'name' => 'girls with guns',
            'type' => 'Image',
            'user_id' => '1',
        ]);

        Groups::create([
            'name' => 'Action shots',
            'type' => 'Image',
            'user_id' => '1',
        ]);

        Groups::create([
            'name' => 'deers',
            'type' => 'Image',
            'user_id' => '1',
        ]);
    }
}

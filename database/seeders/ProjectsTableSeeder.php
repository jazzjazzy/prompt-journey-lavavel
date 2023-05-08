<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::create([
            'user_id' => '2',
            'name' => 'Default',
            'description' => 'My First Project',
        ]);
        Project::create([
            'user_id' => '5',
            'name' => 'Default',
            'description' => 'My First Project',
        ]);
        Project::create([
            'user_id' => '5',
            'name' => 'Car design',
            'description' => 'Designing concept cars',
        ]);

        Project::create([
            'user_id' => '5',
            'name' => 'Mary Smith',
            'description' => 'Main Charactor in my graphic novel',
        ]);

        Project::create([
            'user_id' => '5',
            'name' => 'John Smith',
            'description' => 'Husband of Mary Smith',
        ]);

        Project::create([
            'user_id' => '5',
            'name' => 'Joseph staskling',
            'description' => 'American Civil War Soldier who fought for the Union in the 1st Minnesota Volunteer Infantry Regiment',
        ]);

        Project::create([
            'user_id' => '5',
            'name' => 'Bill Staskling',
            'description' => 'Confereate Soldier who fought for the Confederacy in the 1st Virginia Volunteer Infantry Regiment',
        ]);

        Project::create([
            'user_id' => '5',
            'name' => 'claxcson Furry',
            'description' => 'A small alien from the planet Zorg, who has come to earth to learn about humans and eat their brains',
        ]);

        Project::create([
            'user_id' => '5',
            'name' => 'Acme Corp',
            'description' => 'Building design for Acme Corp, a company that makes everything',
        ]);

        Project::create([
            'user_id' => '5',
            'name' => 'Single wheeled virbating bicycle',
            'description' => 'I dont know why I designed this, but it was fun',
        ]);

        Project::create([
            'user_id' => '5',
            'name' => 'cartoon and comic characters',
            'description' => 'just reandom characters I have designed over the years',
        ]);

        Project::create([
            'user_id' => '1',
            'name' => 'Default',
            'description' => 'My first project',
        ]);

        Project::create([
            'user_id' => '6',
            'name' => 'Default',
            'description' => 'My first project',
        ]);

        Project::create([
            'user_id' => '4',
            'name' => 'Tester',
            'description' => 'Your tester project',
        ]);

    }
}

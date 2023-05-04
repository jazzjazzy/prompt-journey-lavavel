<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ImageGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('image_group')->insert(['image_id' => 1,'group_id' => 2 ]);
        DB::table('image_group')->insert(['image_id' => 2,'group_id' => 3 ]);
        DB::table('image_group')->insert(['image_id' => 3,'group_id' => 3 ]);
        DB::table('image_group')->insert(['image_id' => 4,'group_id' => 3 ]);
        DB::table('image_group')->insert(['image_id' => 5,'group_id' => 3 ]);
        DB::table('image_group')->insert(['image_id' => 6,'group_id' => 3 ]);
        DB::table('image_group')->insert(['image_id' => 7,'group_id' => 4 ]);
        DB::table('image_group')->insert(['image_id' => 8,'group_id' => 1 ]);
        DB::table('image_group')->insert(['image_id' => 9,'group_id' => 1 ]);
        DB::table('image_group')->insert(['image_id' => 10,'group_id' => 1 ]);
        DB::table('image_group')->insert(['image_id' => 11,'group_id' => 1 ]);
        DB::table('image_group')->insert(['image_id' => 12,'group_id' => 1 ]);
        DB::table('image_group')->insert(['image_id' => 13,'group_id' => 2 ]);
        DB::table('image_group')->insert(['image_id' => 14,'group_id' => 2 ]);
        DB::table('image_group')->insert(['image_id' => 15,'group_id' => 2 ]);
        DB::table('image_group')->insert(['image_id' => 16,'group_id' => 2 ]);
        DB::table('image_group')->insert(['image_id' => 17,'group_id' => 2 ]);
        DB::table('image_group')->insert(['image_id' => 18,'group_id' => 5 ]);
        DB::table('image_group')->insert(['image_id' => 19,'group_id' => 5 ]);
        DB::table('image_group')->insert(['image_id' => 20,'group_id' => 5 ]);
        DB::table('image_group')->insert(['image_id' => 21,'group_id' => 5 ]);
        DB::table('image_group')->insert(['image_id' => 22,'group_id' => 5 ]);
    }
}

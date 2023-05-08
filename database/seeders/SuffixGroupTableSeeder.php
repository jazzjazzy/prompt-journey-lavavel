<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SuffixGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suffix_group')->insert(['suffix_id' => 1,'group_id' => 6 ]);
        DB::table('suffix_group')->insert(['suffix_id' => 2,'group_id' => 6 ]);
        DB::table('suffix_group')->insert(['suffix_id' => 3,'group_id' => 6 ]);
        DB::table('suffix_group')->insert(['suffix_id' => 4,'group_id' => 6 ]);
        DB::table('suffix_group')->insert(['suffix_id' => 5,'group_id' => 7 ]);
        DB::table('suffix_group')->insert(['suffix_id' => 6,'group_id' => 7 ]);
        DB::table('suffix_group')->insert(['suffix_id' => 7,'group_id' => 7 ]);
        DB::table('suffix_group')->insert(['suffix_id' => 8,'group_id' => 7 ]);
        DB::table('suffix_group')->insert(['suffix_id' => 9,'group_id' => 7 ]);
    }
}

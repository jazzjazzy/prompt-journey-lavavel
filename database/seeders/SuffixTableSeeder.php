<?php

namespace Database\Seeders;

use App\Models\Suffixes as Suffix;
use Illuminate\Database\Seeder;

class SuffixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Suffix::create([
            'name' => 'vibrant',
            'suffix' => 'Vibrant and colorful, Realistic and detailed, 8k resolution',
            'user_id' => '6',
        ]);

        Suffix::create([
            'name' => 'Intricate',
            'suffix' => 'Intricate and complex, Minimalistic and simple, Retro and vintage',
            'user_id' => '6',
        ]);

        Suffix::create([
            'name' => 'Fururistic hand-drawn',
            'suffix' => 'Futuristic and modern, Hand-drawn and artistic, Monochromatic and grayscale',
            'user_id' => '6',
        ]);

        Suffix::create([
            'name' => 'bold eye catching',
            'suffix' => 'Bold and eye-catching, Vibrant and colorful, Realistic and detailed',
            'user_id' => '6',
        ]);

        Suffix::create([
            'name' => 'Sony a7R',
            'suffix' => 'Sony a7R IV camera, Meike 85mm F1.8 lens',
            'user_id' => '6',
        ]);

        Suffix::create([
            'name' => 'Porta',
            'suffix' => 'Kodak Portra 800 film SMC Takumar 35mm f/ 2. 8 c 50',
            'user_id' => '6',
        ]);

        Suffix::create([
            'name' => 'fomapan',
            'suffix' => 'Fomapan 400',
            'user_id' => '6',
        ]);

        Suffix::create([
            'name' => 'Fujicolour',
            'suffix' => 'Fujicolor Superia X-TRA 400',
            'user_id' => '6',
        ]);

        Suffix::create([
            'name' => 'Canon Eos R5',
            'suffix' => 'Canon EOS R5 camera with a 100mm lens at F 1.2',
            'user_id' => '6',
        ]);
    }
}

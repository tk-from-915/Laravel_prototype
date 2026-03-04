<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'foliage',   'name' => '観葉植物'],
            ['slug' => 'succulent', 'name' => '多肉植物'],
            ['slug' => 'bonsai',    'name' => '盆栽'],
            ['slug' => 'flower',    'name' => '生花'],
            ['slug' => 'caudex',    'name' => '塊根植物'],
            ['slug' => 'epiphyte',  'name' => '着生植物'],
            ['slug' => 'tropical',  'name' => '熱帯植物'],
            ['slug' => 'terrarium', 'name' => 'テラリウム・パルダリウム'],
            ['slug' => 'goods',     'name' => 'グッズ'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $category['slug']],
                array_merge($category, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]),
            );
        }
    }
}

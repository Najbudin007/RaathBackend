<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Tag::truncate();
        $tags = [
            [
                'title' => 'Science',
                'slug' => 'science',
            ],
            [
                'title' => 'Technology',
                'slug' => 'technology',
            ],
            [
                'title' => 'Engineering',
                'slug' => 'engineering',
            ],
            [
                'title' => 'Mathematics',
                'slug' => 'mathematics',
            ]
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }



        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

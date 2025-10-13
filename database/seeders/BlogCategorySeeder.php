<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        BlogCategory::truncate();
        $categories = [[
            'name' => 'Technology',
            'status' => 1
        ], [
            'name' => 'Science',
            'status' => 1
        ]];
        
        foreach ($categories as $category) {
            BlogCategory::create($category);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PortfolioCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PortfolioCategory::truncate();
        $categories = [[
            'title' => 'Porftfolio1',
            'status' => 1
        ], [
            'title' => 'Portfolio2',
            'status' => 1
        ]];
        
        foreach ($categories as $category) {
            PortfolioCategory::create($category);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

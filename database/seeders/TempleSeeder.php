<?php

namespace Database\Seeders;

use App\Models\Temple;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TempleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Temple::create(['country' => 'India', 'count' => 125, 'lat' => 20.5937, 'lng' => 78.9629]);
        Temple::create(['country' => 'USA', 'count' => 55, 'lat' => 37.0902, 'lng' => -95.7129]);
        Temple::create(['country' => 'Europe', 'count' => 45, 'lat' => 54.5260, 'lng' => 15.2551]);
        Temple::create(['country' => 'Others', 'count' => 200, 'lat' => null, 'lng' => null]);
        Temple::create(['country' => 'Asia', 'count' => 75, 'lat' => 34.0479, 'lng' => 100.6197]);
        Temple::create(['country' => 'Africa', 'count' => 30, 'lat' => -8.7832, 'lng' => 34.5085]);
        Temple::create(['country' => 'Nepal', 'count' => 20, 'lat' => -25.2744, 'lng' => 133.7751]);
        Temple::create(['country' => 'Australia', 'count' => 15, 'lat' => -25.2744, 'lng' => 133.7751]);
        Temple::create(['country' => 'Canada', 'count' => 10, 'lat' => 56.1304, 'lng' => -106.3468]);
        Temple::create(['country' => 'South America', 'count' => 5, 'lat' => -8.7832, 'lng' => -55.4915]);
        Temple::create(['country' => 'Middle East', 'count' => 8, 'lat' => 25.276987, 'lng' => 55.296249]);
    }
}

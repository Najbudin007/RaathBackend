<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Kitchen & Prasadam Service',
            'Kirtan & Music',
            'Community Outreach',
            'Media & Communications',
            'Event Management',
            'Education & Teaching',
        ];

        foreach ($departments as $name) {
            DB::table('departments')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

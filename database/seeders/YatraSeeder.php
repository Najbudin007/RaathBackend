<?php

namespace Database\Seeders;

use App\Models\Yatra;
use Illuminate\Database\Seeder;

class YatraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $yatras = [
            [
                'title' => 'Kathmandu Rathyatra 2026',
                'description' => 'Annual Rathyatra celebration in the heart of Kathmandu',
                'city' => 'Kathmandu',
                'month' => 'March',
                'collaborating_center' => 'ISKCON Kathmandu',
                'start_date' => '2026-03-15',
                'end_date' => '2026-03-17',
                'status' => 'upcoming',
                'is_featured' => true,
                'sort_order' => 1,
                'details' => [
                    'route' => 'Thamel to Durbar Square',
                    'expected_participants' => 5000,
                    'special_events' => ['Prasadam distribution', 'Cultural programs']
                ],
            ],
            [
                'title' => 'Patan Rathyatra 2026',
                'description' => 'Sacred Rathyatra in the ancient city of Patan',
                'city' => 'Patan',
                'month' => 'April',
                'collaborating_center' => 'ISKCON Patan',
                'start_date' => '2026-04-20',
                'end_date' => '2026-04-22',
                'status' => 'upcoming',
                'is_featured' => false,
                'sort_order' => 2,
                'details' => [
                    'route' => 'Patan Durbar to Golden Temple',
                    'expected_participants' => 3000,
                    'special_events' => ['Bhajan programs', 'Prasadam seva']
                ],
            ],
            [
                'title' => 'Bhaktapur Rathyatra 2026',
                'description' => 'Traditional Rathyatra in the cultural city of Bhaktapur',
                'city' => 'Bhaktapur',
                'month' => 'May',
                'collaborating_center' => 'ISKCON Bhaktapur',
                'start_date' => '2026-05-10',
                'end_date' => '2026-05-12',
                'status' => 'upcoming',
                'is_featured' => false,
                'sort_order' => 3,
                'details' => [
                    'route' => 'Bhaktapur Durbar to Taumadhi Square',
                    'expected_participants' => 2500,
                    'special_events' => ['Traditional music', 'Cultural dance']
                ],
            ],
            [
                'title' => 'Banepa Rathyatra 2026',
                'description' => 'Community Rathyatra in the peaceful town of Banepa',
                'city' => 'Banepa',
                'month' => 'June',
                'collaborating_center' => 'ISKCON Banepa',
                'start_date' => '2026-06-15',
                'end_date' => '2026-06-17',
                'status' => 'upcoming',
                'is_featured' => false,
                'sort_order' => 4,
                'details' => [
                    'route' => 'Banepa Bazaar to Community Center',
                    'expected_participants' => 1500,
                    'special_events' => ['Community feast', 'Children programs']
                ],
            ],
            [
                'title' => 'Swayambhu Rathyatra 2026',
                'description' => 'Spiritual Rathyatra near the sacred Swayambhu Stupa',
                'city' => 'Swayambhu',
                'month' => 'July',
                'collaborating_center' => 'ISKCON Swayambhu',
                'start_date' => '2026-07-20',
                'end_date' => '2026-07-22',
                'status' => 'upcoming',
                'is_featured' => false,
                'sort_order' => 5,
                'details' => [
                    'route' => 'Swayambhu Stupa to ISKCON Center',
                    'expected_participants' => 2000,
                    'special_events' => ['Meditation sessions', 'Spiritual discourses']
                ],
            ],
        ];

        foreach ($yatras as $yatra) {
            Yatra::create($yatra);
        }
    }
}

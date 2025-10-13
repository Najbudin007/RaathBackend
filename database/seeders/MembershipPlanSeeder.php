<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Member',
                'tier_name' => 'Bronze',
                'color_theme' => '#cd7f32',
                'description' => 'Basic membership with essential benefits for temple community participation',
                'price' => 500.00,
                'duration_days' => 365,
                'benefits' => [
                    'Monthly newsletter',
                    'Event notifications',
                    'Basic seating priority',
                    'Community access'
                ],
                'detailed_benefits' => [
                    [
                        'title' => 'Monthly Newsletter',
                        'description' => 'Receive monthly updates about temple activities, upcoming events, and spiritual insights'
                    ],
                    [
                        'title' => 'Event Notifications',
                        'description' => 'Get notified about special ceremonies, festivals, and community events'
                    ],
                    [
                        'title' => 'Basic Seating Priority',
                        'description' => 'Priority seating during regular ceremonies and events'
                    ]
                ],
                'seating_priority' => 'Standard',
                'annual_kit_type' => 'Basic Spiritual Kit',
                'newsletter_frequency' => 'Monthly',
                'events_access' => 'Public Events Only',
                'certificate_type' => 'Digital Certificate',
                'is_volunteer_based' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Premium Member',
                'tier_name' => 'Silver',
                'color_theme' => '#c0c0c0',
                'description' => 'Premium membership with enhanced benefits and exclusive access',
                'price' => 1500.00,
                'duration_days' => 365,
                'benefits' => [
                    'All Basic benefits',
                    'VIP seating',
                    'Exclusive events',
                    'Annual spiritual kit',
                    'Personal consultation'
                ],
                'detailed_benefits' => [
                    [
                        'title' => 'VIP Seating',
                        'description' => 'Premium seating in the main hall during all ceremonies'
                    ],
                    [
                        'title' => 'Exclusive Events',
                        'description' => 'Access to member-only events and special ceremonies'
                    ],
                    [
                        'title' => 'Annual Spiritual Kit',
                        'description' => 'Receive a curated spiritual kit with prayer items and literature'
                    ]
                ],
                'seating_priority' => 'VIP',
                'annual_kit_type' => 'Premium Spiritual Kit',
                'newsletter_frequency' => 'Bi-weekly',
                'events_access' => 'All Events',
                'certificate_type' => 'Premium Certificate',
                'is_volunteer_based' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Lifetime Member',
                'tier_name' => 'Gold',
                'color_theme' => '#ffd700',
                'description' => 'Lifetime membership with all premium benefits and legacy recognition',
                'price' => 10000.00,
                'duration_days' => 36500, // ~100 years
                'benefits' => [
                    'All Premium benefits',
                    'Lifetime access',
                    'Legacy recognition',
                    'Annual pilgrimage',
                    'Personal spiritual guide'
                ],
                'detailed_benefits' => [
                    [
                        'title' => 'Lifetime Access',
                        'description' => 'Permanent access to all temple facilities and services'
                    ],
                    [
                        'title' => 'Legacy Recognition',
                        'description' => 'Your name will be inscribed in our temple legacy wall'
                    ],
                    [
                        'title' => 'Annual Pilgrimage',
                        'description' => 'Annual sponsored pilgrimage to major spiritual centers'
                    ]
                ],
                'seating_priority' => 'Premium',
                'annual_kit_type' => 'Luxury Spiritual Kit',
                'newsletter_frequency' => 'Weekly',
                'events_access' => 'All Events + Private',
                'certificate_type' => 'Lifetime Certificate',
                'is_volunteer_based' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($plans as $plan) {
            MembershipPlan::create($plan);
        }
    }
}

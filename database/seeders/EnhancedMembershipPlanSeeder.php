<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnhancedMembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing membership plans
        MembershipPlan::truncate();

        // Create enhanced membership plans based on the page
        $plans = [
            [
                'name' => 'Jagannath Member',
                'tier_name' => 'Jagannath',
                'color_theme' => '#FFD700', // Gold
                'description' => 'Premium membership with exclusive benefits and front-row access',
                'price' => 25000.00,
                'duration_days' => 365,
                'benefits' => [
                    'Front row seating at all yatras',
                    'Annual blessed kit with sacred items',
                    'Monthly newsletter with spiritual content',
                    'Priority darshan opportunities',
                    'Exclusive member events',
                    'Personalized certificate',
                    'Direct access to organizing committee'
                ],
                'detailed_benefits' => [
                    'Front row seating at all yatras',
                    'Annual blessed kit with sacred items',
                    'Monthly newsletter with spiritual content',
                    'Priority darshan opportunities',
                    'Exclusive member events',
                    'Personalized certificate',
                    'Direct access to organizing committee'
                ],
                'seating_priority' => 'Front VIP',
                'annual_kit_type' => 'Premium',
                'newsletter_frequency' => 'Monthly',
                'events_access' => 'All + Exclusive',
                'certificate_type' => 'Personalized',
                'is_volunteer_based' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Baladev Member',
                'tier_name' => 'Baladev',
                'color_theme' => '#0066CC', // Blue
                'description' => 'Enhanced membership with reserved seating and special privileges',
                'price' => 15000.00,
                'duration_days' => 365,
                'benefits' => [
                    'Reserved seating at yatras',
                    'Bi-annual blessed kit',
                    'Quarterly newsletter',
                    'Member-only kirtan sessions',
                    'Festival participation priority',
                    'Digital membership certificate'
                ],
                'detailed_benefits' => [
                    'Reserved seating at yatras',
                    'Bi-annual blessed kit',
                    'Quarterly newsletter',
                    'Member-only kirtan sessions',
                    'Festival participation priority',
                    'Digital membership certificate'
                ],
                'seating_priority' => 'Reserved',
                'annual_kit_type' => 'Standard',
                'newsletter_frequency' => 'Quarterly',
                'events_access' => 'All Events',
                'certificate_type' => 'Digital',
                'is_volunteer_based' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Subhadra Member',
                'tier_name' => 'Subhadra',
                'color_theme' => '#FF69B4', // Pink
                'description' => 'Standard membership with general access and community benefits',
                'price' => 10000.00,
                'duration_days' => 365,
                'benefits' => [
                    'General seating at all events',
                    'Annual newsletter',
                    'Basic member kit',
                    'Access to member WhatsApp group',
                    'Volunteer opportunities',
                    'Digital certificate'
                ],
                'detailed_benefits' => [
                    'General seating at all events',
                    'Annual newsletter',
                    'Basic member kit',
                    'Access to member WhatsApp group',
                    'Volunteer opportunities',
                    'Digital certificate'
                ],
                'seating_priority' => 'General',
                'annual_kit_type' => 'Basic',
                'newsletter_frequency' => 'Annual',
                'events_access' => 'Major Events',
                'certificate_type' => 'Digital',
                'is_volunteer_based' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Prabhupada Member',
                'tier_name' => 'Prabhupada',
                'color_theme' => '#800080', // Purple
                'description' => 'Basic membership with essential community access',
                'price' => 5000.00,
                'duration_days' => 365,
                'benefits' => [
                    'Basic event access',
                    'Digital newsletter',
                    'Simple member kit',
                    'Community updates',
                    'Basic volunteer rights'
                ],
                'detailed_benefits' => [
                    'Basic event access',
                    'Digital newsletter',
                    'Simple member kit',
                    'Community updates',
                    'Basic volunteer rights'
                ],
                'seating_priority' => 'Basic',
                'annual_kit_type' => 'Simple',
                'newsletter_frequency' => 'Digital',
                'events_access' => 'Basic',
                'certificate_type' => 'Digital',
                'is_volunteer_based' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Jayananda Prabhu Member',
                'tier_name' => 'Jayananda',
                'color_theme' => '#228B22', // Green
                'description' => 'Volunteer-based membership focused on service and community',
                'price' => 0.00,
                'duration_days' => 365,
                'benefits' => [
                    'Service-based membership',
                    'Recognition for volunteer work',
                    'Special volunteer certificate',
                    'Behind-scenes access',
                    'Skill development opportunities',
                    'Community leadership roles'
                ],
                'detailed_benefits' => [
                    'Service-based membership',
                    'Recognition for volunteer work',
                    'Special volunteer certificate',
                    'Behind-scenes access',
                    'Skill development opportunities',
                    'Community leadership roles'
                ],
                'seating_priority' => 'Service Area',
                'annual_kit_type' => 'Volunteer',
                'newsletter_frequency' => 'Updates',
                'events_access' => 'Behind Scenes',
                'certificate_type' => 'Volunteer',
                'is_volunteer_based' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($plans as $plan) {
            MembershipPlan::create($plan);
        }

        $this->command->info('Enhanced membership plans seeded successfully!');
    }
}

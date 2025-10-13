<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\SponsorshipTier;
use App\Models\BudgetBreakdown;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Rath Making Project',
                'slug' => 'rath-making-project',
                'description' => 'A comprehensive project to build a magnificent Rath (chariot) for religious ceremonies and festivals. This traditional chariot will be used during major celebrations and will serve as a symbol of devotion and community unity.',
                'short_description' => 'Building a traditional Rath for spiritual celebrations',
                'vision' => 'To create a magnificent Rath that will serve as a symbol of devotion and bring communities together in spiritual celebration.',
                'technical_specs' => 'The Rath will be constructed using traditional woodworking techniques with modern safety standards. Dimensions: 15ft x 8ft x 12ft. Materials: Teak wood, brass fittings, decorative elements.',
                'design_docs' => [
                    'technical_drawings' => 'rath_technical_drawings.pdf',
                    '3d_model' => 'rath_3d_model.stl',
                    'artwork' => 'rath_design_concept.jpg'
                ],
                'image' => 'projects/rath-making-main.jpg',
                'images' => [
                    'projects/rath-design-1.jpg',
                    'projects/rath-design-2.jpg',
                    'projects/rath-materials.jpg'
                ],
                'target_amount' => 2500000.00,
                'collected_amount' => 1250000.00,
                'budget' => 2400000.00,
                'start_date' => '2024-01-01',
                'end_date' => '2025-12-31',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'title' => 'Temple Renovation & Expansion',
                'slug' => 'temple-renovation-expansion',
                'description' => 'A major renovation project to expand our temple facilities, including a new prayer hall, meditation center, and community space. This project will accommodate our growing congregation and provide modern amenities while preserving the traditional architecture.',
                'short_description' => 'Expanding temple facilities for growing community',
                'vision' => 'To create a modern, spacious temple complex that serves as a spiritual hub for our community while maintaining traditional values.',
                'technical_specs' => 'New construction of 5000 sq ft prayer hall, 2000 sq ft meditation center, and 3000 sq ft community space. Renovation of existing structures with earthquake-resistant design.',
                'design_docs' => [
                    'architectural_plans' => 'temple_expansion_plans.pdf',
                    'structural_analysis' => 'structural_analysis.pdf',
                    '3d_rendering' => 'temple_3d_render.jpg'
                ],
                'image' => 'projects/temple-renovation-main.jpg',
                'images' => [
                    'projects/temple-exterior.jpg',
                    'projects/prayer-hall-design.jpg',
                    'projects/meditation-center.jpg'
                ],
                'target_amount' => 5000000.00,
                'collected_amount' => 2750000.00,
                'budget' => 4800000.00,
                'start_date' => '2024-03-01',
                'end_date' => '2026-06-30',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'title' => 'Digital Library & Learning Center',
                'slug' => 'digital-library-learning-center',
                'description' => 'Establishing a state-of-the-art digital library and learning center to preserve ancient scriptures, provide educational resources, and offer online courses on Hindu philosophy, Sanskrit, and spiritual practices.',
                'short_description' => 'Creating digital resources for spiritual education',
                'vision' => 'To make ancient wisdom accessible to modern seekers through technology while preserving our cultural heritage for future generations.',
                'technical_specs' => 'Digital scanning of 10,000+ manuscripts, cloud storage system, interactive learning platform, and multimedia content creation studio.',
                'design_docs' => [
                    'technical_specifications' => 'digital_library_specs.pdf',
                    'software_architecture' => 'software_architecture.pdf',
                    'content_strategy' => 'content_strategy.pdf'
                ],
                'image' => 'projects/digital-library-main.jpg',
                'images' => [
                    'projects/library-interior.jpg',
                    'projects/digitization-setup.jpg',
                    'projects/learning-platform.jpg'
                ],
                'target_amount' => 1500000.00,
                'collected_amount' => 750000.00,
                'budget' => 1400000.00,
                'start_date' => '2024-06-01',
                'end_date' => '2025-12-31',
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'title' => 'Community Kitchen & Food Bank',
                'slug' => 'community-kitchen-food-bank',
                'description' => 'Establishing a community kitchen that provides free meals to the needy and operates as a food bank for families in crisis. This project embodies the principle of selfless service and community support.',
                'short_description' => 'Serving free meals and supporting families in need',
                'vision' => 'To eliminate hunger in our community through the power of seva (selfless service) and create a sustainable food security program.',
                'technical_specs' => 'Commercial kitchen with capacity to serve 500 meals daily, cold storage facilities, food distribution network, and volunteer coordination system.',
                'design_docs' => [
                    'kitchen_layout' => 'kitchen_layout.pdf',
                    'food_safety_protocols' => 'food_safety_protocols.pdf',
                    'distribution_network' => 'distribution_network.pdf'
                ],
                'image' => 'projects/community-kitchen-main.jpg',
                'images' => [
                    'projects/kitchen-equipment.jpg',
                    'projects/food-distribution.jpg',
                    'projects/volunteers-at-work.jpg'
                ],
                'target_amount' => 800000.00,
                'collected_amount' => 320000.00,
                'budget' => 750000.00,
                'start_date' => '2024-04-01',
                'end_date' => '2025-08-31',
                'status' => 'active',
                'is_featured' => true,
            ],
            [
                'title' => 'Youth Education & Skill Development',
                'slug' => 'youth-education-skill-development',
                'description' => 'A comprehensive program to provide quality education and skill development opportunities for underprivileged youth. The project includes scholarships, vocational training, and mentorship programs.',
                'short_description' => 'Empowering youth through education and skills',
                'vision' => 'To create opportunities for every young person to realize their potential and contribute meaningfully to society.',
                'technical_specs' => 'Computer lab with 50 workstations, vocational training center, library with 5000+ books, and mentorship matching system.',
                'design_docs' => [
                    'education_curriculum' => 'education_curriculum.pdf',
                    'skill_training_modules' => 'skill_training_modules.pdf',
                    'mentorship_framework' => 'mentorship_framework.pdf'
                ],
                'image' => 'projects/youth-education-main.jpg',
                'images' => [
                    'projects/computer-lab.jpg',
                    'projects/vocational-training.jpg',
                    'projects/mentorship-session.jpg'
                ],
                'target_amount' => 1200000.00,
                'collected_amount' => 480000.00,
                'budget' => 1100000.00,
                'start_date' => '2024-05-01',
                'end_date' => '2026-04-30',
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'title' => 'Elderly Care & Support Center',
                'slug' => 'elderly-care-support-center',
                'description' => 'Creating a dedicated center for elderly care that provides medical support, social activities, and spiritual guidance for senior members of our community.',
                'short_description' => 'Caring for our elders with love and respect',
                'vision' => 'To honor our elders by providing them with comprehensive care, companionship, and opportunities for continued spiritual growth.',
                'technical_specs' => 'Medical consultation room, physiotherapy center, recreational facilities, and residential care units for 25 residents.',
                'design_docs' => [
                    'facility_design' => 'elderly_care_design.pdf',
                    'medical_protocols' => 'medical_protocols.pdf',
                    'care_programs' => 'care_programs.pdf'
                ],
                'image' => 'projects/elderly-care-main.jpg',
                'images' => [
                    'projects/medical-facility.jpg',
                    'projects/recreation-area.jpg',
                    'projects/spiritual-activities.jpg'
                ],
                'target_amount' => 2000000.00,
                'collected_amount' => 800000.00,
                'budget' => 1850000.00,
                'start_date' => '2024-07-01',
                'end_date' => '2026-06-30',
                'status' => 'planning',
                'is_featured' => false,
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::create($projectData);

            // Create sponsorship tiers based on project type
            if ($project->slug === 'rath-making-project') {
                $sponsorshipTiers = [
                    [
                        'name' => 'Jagannath Sevak',
                        'description' => 'Ultimate sponsorship with exclusive benefits and front-row access',
                        'amount' => 500000.00,
                        'benefits' => [
                            'Front & Back inscription on Rath',
                            'Front VIP seating at all ceremonies',
                            'Personal Aarti participation',
                            'Gold badge and premium gifts',
                            'Exclusive ceremony participation'
                        ],
                        'inscription_type' => 'both',
                        'gifts' => ['Shawl', 'Prasadam', 'ID Badge', 'Gold Badge'],
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Baladev Sevak',
                        'description' => 'Premium sponsorship with enhanced recognition',
                        'amount' => 250000.00,
                        'benefits' => [
                            'Side panel inscription on Rath',
                            'Mid VIP seating at ceremonies',
                            'Aarti participation',
                            'Silver badge and gifts'
                        ],
                        'inscription_type' => 'both',
                        'gifts' => ['Shawl', 'T-shirt', 'Silver Badge'],
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Subhadra Sevak',
                        'description' => 'Standard sponsorship with community recognition',
                        'amount' => 100000.00,
                        'benefits' => [
                            'Thank you board inscription',
                            'General seating at ceremonies',
                            'Aarti invitation',
                            'Community recognition'
                        ],
                        'inscription_type' => 'name',
                        'gifts' => ['T-shirt', 'Bronze Badge'],
                        'sort_order' => 3,
                    ],
                    [
                        'name' => 'Prabhupada Sevak',
                        'description' => 'Basic support with digital recognition',
                        'amount' => 50000.00,
                        'benefits' => [
                            'Website inscription only',
                            'General seating',
                            'Optional Aarti participation',
                            'Digital certificate'
                        ],
                        'inscription_type' => 'name',
                        'gifts' => ['Digital Certificate', 'Supporter Badge'],
                        'sort_order' => 4,
                    ],
                ];
            } else {
                // Default tiers for other projects
                $sponsorshipTiers = [
                    [
                        'name' => 'Friend of the Project',
                        'description' => 'Basic support level with recognition',
                        'amount' => 1000.00,
                        'benefits' => ['Name in donor list', 'Thank you certificate'],
                        'inscription_type' => 'name',
                        'gifts' => ['Thank you certificate'],
                        'sort_order' => 1,
                    ],
                    [
                        'name' => 'Supporter',
                        'description' => 'Enhanced support with additional benefits',
                        'amount' => 5000.00,
                        'benefits' => ['Name in donor list', 'Special certificate', 'Invitation to events'],
                        'inscription_type' => 'name',
                        'gifts' => ['Special certificate', 'Commemorative item'],
                        'sort_order' => 2,
                    ],
                    [
                        'name' => 'Patron',
                        'description' => 'Major support with prominent recognition',
                        'amount' => 10000.00,
                        'benefits' => ['Prominent name recognition', 'VIP event access', 'Special privileges'],
                        'inscription_type' => 'both',
                        'gifts' => ['Premium certificate', 'VIP pass', 'Special privileges'],
                        'sort_order' => 3,
                    ],
                ];
            }

            foreach ($sponsorshipTiers as $tier) {
                SponsorshipTier::create(array_merge($tier, ['project_id' => $project->id]));
            }

            // Create budget breakdown based on project type
            if ($project->slug === 'rath-making-project') {
                $budgetBreakdowns = [
                    [
                        'category' => 'Chassis & Framework',
                        'description' => 'Main structural framework and chassis construction',
                        'amount' => $project->budget * 0.4,
                        'percentage' => 40.00,
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'Hydraulic System',
                        'description' => 'Hydraulic lifting system for deity platform',
                        'amount' => $project->budget * 0.2,
                        'percentage' => 20.00,
                        'sort_order' => 2,
                    ],
                    [
                        'category' => 'Artistic Work & Decoration',
                        'description' => 'Traditional artwork, carving, and decorative elements',
                        'amount' => $project->budget * 0.3,
                        'percentage' => 30.00,
                        'sort_order' => 3,
                    ],
                    [
                        'category' => 'Sound System & Electronics',
                        'description' => 'Audio system and electronic components for ceremonies',
                        'amount' => $project->budget * 0.1,
                        'percentage' => 10.00,
                        'sort_order' => 4,
                    ],
                ];
            } else {
                // Default budget breakdown for other projects
                $budgetBreakdowns = [
                    [
                        'category' => 'Materials & Equipment',
                        'description' => 'Primary materials and equipment needed for the project',
                        'amount' => $project->budget * 0.4,
                        'percentage' => 40.00,
                        'sort_order' => 1,
                    ],
                    [
                        'category' => 'Labor & Professional Services',
                        'description' => 'Skilled labor and professional services',
                        'amount' => $project->budget * 0.3,
                        'percentage' => 30.00,
                        'sort_order' => 2,
                    ],
                    [
                        'category' => 'Administration & Operations',
                        'description' => 'Administrative costs and operational expenses',
                        'amount' => $project->budget * 0.15,
                        'percentage' => 15.00,
                        'sort_order' => 3,
                    ],
                    [
                        'category' => 'Marketing & Communication',
                        'description' => 'Promotional materials and communication costs',
                        'amount' => $project->budget * 0.1,
                        'percentage' => 10.00,
                        'sort_order' => 4,
                    ],
                    [
                        'category' => 'Contingency',
                        'description' => 'Reserve fund for unforeseen expenses',
                        'amount' => $project->budget * 0.05,
                        'percentage' => 5.00,
                        'sort_order' => 5,
                    ],
                ];
            }

            foreach ($budgetBreakdowns as $breakdown) {
                BudgetBreakdown::create(array_merge($breakdown, ['project_id' => $project->id]));
            }
        }

        $this->command->info('Projects seeded successfully!');
    }
}

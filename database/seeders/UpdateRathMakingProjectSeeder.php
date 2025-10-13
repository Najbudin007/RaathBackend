<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\SponsorshipTier;
use App\Models\BudgetBreakdown;
use Illuminate\Database\Seeder;

class UpdateRathMakingProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = Project::where('slug', 'rath-making-project')->first();
        
        if (!$project) {
            $this->command->error('Rath Making project not found!');
            return;
        }

        // Clear existing sponsorship tiers and budget breakdowns
        $project->sponsorshipTiers()->delete();
        $project->budgetBreakdowns()->delete();

        // Create new sponsorship tiers for Rath Making project
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

        foreach ($sponsorshipTiers as $tier) {
            SponsorshipTier::create(array_merge($tier, ['project_id' => $project->id]));
        }

        // Create new budget breakdown for Rath Making project
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

        foreach ($budgetBreakdowns as $breakdown) {
            BudgetBreakdown::create(array_merge($breakdown, ['project_id' => $project->id]));
        }

        $this->command->info('Rath Making project updated successfully with new sponsorship tiers and budget breakdown!');
    }
}

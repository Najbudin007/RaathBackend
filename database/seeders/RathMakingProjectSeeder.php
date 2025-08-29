<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\SponsorshipTier;
use App\Models\BudgetBreakdown;
use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RathMakingProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Rath Making Project
        $project = Project::create([
            'title' => 'Rath Making Project',
            'slug' => 'rath-making-project',
            'description' => 'A comprehensive project to build a magnificent Rath (chariot) for religious ceremonies and festivals.',
            'short_description' => 'Building a traditional Rath for spiritual celebrations',
            'vision' => 'To create a magnificent Rath that will serve as a symbol of devotion and bring communities together in spiritual celebration.',
            'technical_specs' => 'The Rath will be constructed using traditional woodworking techniques with modern safety standards. Dimensions: 15ft x 8ft x 12ft. Materials: Teak wood, brass fittings, decorative elements.',
            'design_docs' => [
                'technical_drawings' => 'rath_technical_drawings.pdf',
                '3d_model' => 'rath_3d_model.stl',
                'artwork' => 'rath_design_concept.jpg'
            ],
            'image' => 'rath-project-main.jpg',
            'images' => [
                'rath-design-1.jpg',
                'rath-design-2.jpg',
                'rath-materials.jpg'
            ],
            'target_amount' => 500000.00,
            'collected_amount' => 125000.00,
            'budget' => 500000.00,
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'status' => 'planning',
            'is_featured' => true,
        ]);

        // Create Sponsorship Tiers
        $sponsorshipTiers = [
            [
                'name' => 'Bronze Sponsor',
                'description' => 'Basic sponsorship level with name inscription',
                'amount' => 10000.00,
                'benefits' => ['Name inscription on Rath', 'Certificate of sponsorship', 'Invitation to inauguration'],
                'inscription_type' => 'name',
                'gifts' => ['Sponsorship certificate', 'Small Rath replica'],
                'sort_order' => 1,
            ],
            [
                'name' => 'Silver Sponsor',
                'description' => 'Enhanced sponsorship with logo and additional benefits',
                'amount' => 25000.00,
                'benefits' => ['Name and logo inscription', 'VIP seating at ceremonies', 'Special recognition'],
                'inscription_type' => 'both',
                'gifts' => ['Sponsorship certificate', 'Medium Rath replica', 'VIP pass'],
                'sort_order' => 2,
            ],
            [
                'name' => 'Gold Sponsor',
                'description' => 'Premium sponsorship with maximum visibility',
                'amount' => 50000.00,
                'benefits' => ['Prominent name and logo placement', 'Exclusive ceremony participation', 'Media recognition'],
                'inscription_type' => 'both',
                'gifts' => ['Sponsorship certificate', 'Large Rath replica', 'VIP pass', 'Media coverage'],
                'sort_order' => 3,
            ],
            [
                'name' => 'Platinum Sponsor',
                'description' => 'Ultimate sponsorship with exclusive benefits',
                'amount' => 100000.00,
                'benefits' => ['Exclusive naming rights', 'Ceremony leadership role', 'Dedicated recognition event'],
                'inscription_type' => 'both',
                'gifts' => ['Sponsorship certificate', 'Premium Rath replica', 'All-access pass', 'Dedicated ceremony'],
                'sort_order' => 4,
            ],
        ];

        foreach ($sponsorshipTiers as $tier) {
            SponsorshipTier::create(array_merge($tier, ['project_id' => $project->id]));
        }

        // Create Budget Breakdown
        $budgetBreakdowns = [
            [
                'category' => 'Materials',
                'description' => 'High-quality teak wood, brass fittings, decorative elements',
                'amount' => 200000.00,
                'percentage' => 40.00,
                'sort_order' => 1,
            ],
            [
                'category' => 'Labor',
                'description' => 'Skilled craftsmen and artisans',
                'amount' => 150000.00,
                'percentage' => 30.00,
                'sort_order' => 2,
            ],
            [
                'category' => 'Design & Engineering',
                'description' => 'Technical drawings, 3D modeling, structural analysis',
                'amount' => 50000.00,
                'percentage' => 10.00,
                'sort_order' => 3,
            ],
            [
                'category' => 'Decoration & Finishing',
                'description' => 'Ornamental work, painting, final touches',
                'amount' => 75000.00,
                'percentage' => 15.00,
                'sort_order' => 4,
            ],
            [
                'category' => 'Contingency',
                'description' => 'Additional funds for unforeseen expenses',
                'amount' => 25000.00,
                'percentage' => 5.00,
                'sort_order' => 5,
            ],
        ];

        foreach ($budgetBreakdowns as $breakdown) {
            BudgetBreakdown::create(array_merge($breakdown, ['project_id' => $project->id]));
        }

        // Create Documents
        $documents = [
            [
                'title' => 'Technical Drawings',
                'description' => 'Detailed technical drawings of the Rath structure',
                'type' => 'technical_drawing',
                'file_url' => 'documents/rath_technical_drawings.pdf',
                'file_name' => 'rath_technical_drawings.pdf',
                'file_size' => '2.5 MB',
                'mime_type' => 'application/pdf',
                'category' => 'Technical',
                'sort_order' => 1,
            ],
            [
                'title' => '3D Model',
                'description' => '3D model file for visualization',
                'type' => '3d_model',
                'file_url' => 'documents/rath_3d_model.stl',
                'file_name' => 'rath_3d_model.stl',
                'file_size' => '15.2 MB',
                'mime_type' => 'application/sla',
                'category' => 'Technical',
                'sort_order' => 2,
            ],
            [
                'title' => 'Design Artwork',
                'description' => 'Concept artwork and design sketches',
                'type' => 'artwork',
                'file_url' => 'documents/rath_design_concept.jpg',
                'file_name' => 'rath_design_concept.jpg',
                'file_size' => '3.8 MB',
                'mime_type' => 'image/jpeg',
                'category' => 'Design',
                'sort_order' => 3,
            ],
            [
                'title' => 'Budget PDF',
                'description' => 'Detailed budget breakdown in PDF format',
                'type' => 'budget_pdf',
                'file_url' => 'documents/rath_budget.pdf',
                'file_name' => 'rath_budget.pdf',
                'file_size' => '1.2 MB',
                'mime_type' => 'application/pdf',
                'category' => 'Financial',
                'sort_order' => 4,
            ],
            [
                'title' => 'Excel Sheet',
                'description' => 'Budget calculations in Excel format',
                'type' => 'excel_sheet',
                'file_url' => 'documents/rath_budget.xlsx',
                'file_name' => 'rath_budget.xlsx',
                'file_size' => '856 KB',
                'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'category' => 'Financial',
                'sort_order' => 5,
            ],
            [
                'title' => 'Comparison Sheet',
                'description' => 'Detailed comparison of different Rath designs',
                'type' => 'comparison_sheet',
                'file_url' => 'documents/rath_comparison.pdf',
                'file_name' => 'rath_comparison.pdf',
                'file_size' => '4.1 MB',
                'mime_type' => 'application/pdf',
                'category' => 'Analysis',
                'sort_order' => 6,
            ],
        ];

        foreach ($documents as $document) {
            Document::create(array_merge($document, ['project_id' => $project->id]));
        }

        $this->command->info('Rath Making Project seeded successfully!');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryItems = [
            [
                'title' => 'Devotees of the Path',
                'description' => 'Bhoga, Bhakti, and Bliss - Devotees celebrating the divine journey',
                'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop',
                'category' => 'yatra',
                'type' => 'image',
                'alt_text' => 'Devotees celebrating Rathyatra',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'metadata' => [
                    'photographer' => 'Anonymous',
                    'location' => 'Kathmandu',
                    'year' => '2024'
                ],
            ],
            [
                'title' => 'Sacred Chariot Procession',
                'description' => 'The magnificent chariot carrying Lord Jagannath through the streets',
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&h=600&fit=crop',
                'category' => 'yatra',
                'type' => 'image',
                'alt_text' => 'Sacred chariot procession',
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'metadata' => [
                    'photographer' => 'Anonymous',
                    'location' => 'Patan',
                    'year' => '2024'
                ],
            ],
            [
                'title' => 'Community Celebration',
                'description' => 'People from all walks of life coming together in spiritual harmony',
                'image_url' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&h=600&fit=crop',
                'category' => 'events',
                'type' => 'image',
                'alt_text' => 'Community celebration',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'metadata' => [
                    'photographer' => 'Anonymous',
                    'location' => 'Bhaktapur',
                    'year' => '2024'
                ],
            ],
            [
                'title' => 'Prasadam Distribution',
                'description' => 'Sharing the divine blessings with everyone',
                'image_url' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=800&h=600&fit=crop',
                'category' => 'puja',
                'type' => 'image',
                'alt_text' => 'Prasadam distribution',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'metadata' => [
                    'photographer' => 'Anonymous',
                    'location' => 'Kathmandu',
                    'year' => '2024'
                ],
            ],
            [
                'title' => 'Spiritual Discourses',
                'description' => 'Enlightening spiritual discourses during the festival',
                'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop',
                'category' => 'events',
                'type' => 'image',
                'alt_text' => 'Spiritual discourses',
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
                'metadata' => [
                    'photographer' => 'Anonymous',
                    'location' => 'Swayambhu',
                    'year' => '2024'
                ],
            ],
        ];

        foreach ($galleryItems as $item) {
            Gallery::create($item);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            [
                'name' => 'Puja Items',
                'slug' => 'puja-items',
                'description' => 'Essential items for religious ceremonies',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Incense & Candles',
                'slug' => 'incense-candles',
                'description' => 'Aromatic items for spiritual practices',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Books & Literature',
                'slug' => 'books-literature',
                'description' => 'Religious texts and spiritual literature',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create($categoryData);

            // Create products for each category
            if ($category->slug === 'puja-items') {
                $products = [
                    [
                        'name' => 'Sacred Kumkum',
                        'slug' => 'sacred-kumkum',
                        'description' => 'Traditional red powder for tilak',
                        'price' => 5.99,
                        'stock_quantity' => 100,
                        'is_active' => true,
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Sacred Chandan',
                        'slug' => 'sacred-chandan',
                        'description' => 'Sandalwood paste for religious ceremonies',
                        'price' => 8.99,
                        'stock_quantity' => 50,
                        'is_active' => true,
                        'is_featured' => false,
                    ],
                ];
            } elseif ($category->slug === 'incense-candles') {
                $products = [
                    [
                        'name' => 'Sandalwood Incense',
                        'slug' => 'sandalwood-incense',
                        'description' => 'Pure sandalwood incense sticks',
                        'price' => 12.99,
                        'stock_quantity' => 75,
                        'is_active' => true,
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Ghee Diya',
                        'slug' => 'ghee-diya',
                        'description' => 'Traditional oil lamp for aarti',
                        'price' => 15.99,
                        'stock_quantity' => 30,
                        'is_active' => true,
                        'is_featured' => false,
                    ],
                ];
            } else {
                $products = [
                    [
                        'name' => 'Bhagavad Gita',
                        'slug' => 'bhagavad-gita',
                        'description' => 'Sacred Hindu scripture',
                        'price' => 25.99,
                        'stock_quantity' => 20,
                        'is_active' => true,
                        'is_featured' => true,
                    ],
                ];
            }

            foreach ($products as $productData) {
                $productData['category_id'] = $category->id;
                Product::create($productData);
            }
        }
    }
}

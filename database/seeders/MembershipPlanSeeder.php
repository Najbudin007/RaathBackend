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
                'name' => 'Basic Plan',
                'description' => 'Basic membership with essential benefits',
                'price' => 29.99,
                'duration_days' => 30,
                'benefits' => [
                    'Access to basic content',
                    'Email support',
                    'Monthly newsletter'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Premium Plan',
                'description' => 'Premium membership with advanced features',
                'price' => 59.99,
                'duration_days' => 30,
                'benefits' => [
                    'Access to all content',
                    'Priority support',
                    'Exclusive events',
                    'Advanced features'
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Annual Plan',
                'description' => 'Annual membership with 2 months free',
                'price' => 599.99,
                'duration_days' => 365,
                'benefits' => [
                    'Access to all content',
                    'Priority support',
                    'Exclusive events',
                    'Advanced features',
                    '2 months free',
                    'Annual discount'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            MembershipPlan::create($plan);
        }
    }
}

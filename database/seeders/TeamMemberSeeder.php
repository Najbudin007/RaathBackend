<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamMembers = [
            [
                'name' => 'Swami Vishnu Prasad',
                'position' => 'Head Priest & Spiritual Director',
                'bio' => 'Swami Vishnu Prasad has been serving our temple for over 20 years. He is a renowned spiritual leader with deep knowledge of Vedic traditions and has guided thousands of devotees on their spiritual journey. His teachings focus on the path of devotion and selfless service.',
                'image' => 'team/swami-vishnu-prasad.jpg',
                'email' => 'swami@temple.com',
                'phone' => '+91-98765-43210',
                'facebook' => 'https://facebook.com/swamivishnuprasad',
                'twitter' => 'https://twitter.com/swamivishnu',
                'linkedin' => 'https://linkedin.com/in/swami-vishnu-prasad',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Dr. Priya Sharma',
                'position' => 'Temple Administrator',
                'bio' => 'Dr. Priya Sharma brings over 15 years of administrative experience to our temple. She holds a PhD in Religious Studies and has been instrumental in organizing major festivals and community events. Her dedication to serving the community is truly inspiring.',
                'image' => 'team/dr-priya-sharma.jpg',
                'email' => 'priya@temple.com',
                'phone' => '+91-98765-43211',
                'facebook' => 'https://facebook.com/drpriyasharma',
                'twitter' => 'https://twitter.com/drpriyasharma',
                'linkedin' => 'https://linkedin.com/in/dr-priya-sharma',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Rajesh Kumar',
                'position' => 'Cultural Program Coordinator',
                'bio' => 'Rajesh Kumar is our cultural program coordinator with a passion for preserving and promoting traditional arts. He has organized numerous cultural events, dance performances, and music concerts that showcase the rich heritage of our community.',
                'image' => 'team/rajesh-kumar.jpg',
                'email' => 'rajesh@temple.com',
                'phone' => '+91-98765-43212',
                'facebook' => 'https://facebook.com/rajeshkumar',
                'twitter' => 'https://twitter.com/rajeshkumar',
                'linkedin' => 'https://linkedin.com/in/rajesh-kumar',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sister Meera Devi',
                'position' => 'Community Outreach Coordinator',
                'bio' => 'Sister Meera Devi has dedicated her life to serving the community through various outreach programs. She coordinates food distribution, educational programs, and social welfare activities. Her compassionate nature and organizational skills make her an invaluable member of our team.',
                'image' => 'team/sister-meera-devi.jpg',
                'email' => 'meera@temple.com',
                'phone' => '+91-98765-43213',
                'facebook' => 'https://facebook.com/sistermeeradevi',
                'twitter' => 'https://twitter.com/sistermeera',
                'linkedin' => 'https://linkedin.com/in/sister-meera-devi',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Amit Singh',
                'position' => 'Youth Program Director',
                'bio' => 'Amit Singh leads our youth programs and activities, bringing energy and innovation to engage young devotees. He organizes workshops, sports events, and educational seminars that help youth connect with their spiritual roots while building a strong community bond.',
                'image' => 'team/amit-singh.jpg',
                'email' => 'amit@temple.com',
                'phone' => '+91-98765-43214',
                'facebook' => 'https://facebook.com/amitsingh',
                'twitter' => 'https://twitter.com/amitsingh',
                'linkedin' => 'https://linkedin.com/in/amit-singh',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Dr. Anjali Gupta',
                'position' => 'Education & Research Head',
                'bio' => 'Dr. Anjali Gupta heads our education and research department. She has a PhD in Sanskrit Literature and has authored several books on Hindu philosophy. She conducts regular classes on scriptures, philosophy, and spiritual practices for all age groups.',
                'image' => 'team/dr-anjali-gupta.jpg',
                'email' => 'anjali@temple.com',
                'phone' => '+91-98765-43215',
                'facebook' => 'https://facebook.com/dranjaligupta',
                'twitter' => 'https://twitter.com/dranjaligupta',
                'linkedin' => 'https://linkedin.com/in/dr-anjali-gupta',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Vikram Joshi',
                'position' => 'Technical & Media Coordinator',
                'bio' => 'Vikram Joshi manages our technical infrastructure and media presence. He ensures that our online services, live streaming of events, and digital communications run smoothly. His technical expertise helps us reach devotees worldwide through modern technology.',
                'image' => 'team/vikram-joshi.jpg',
                'email' => 'vikram@temple.com',
                'phone' => '+91-98765-43216',
                'facebook' => 'https://facebook.com/vikramjoshi',
                'twitter' => 'https://twitter.com/vikramjoshi',
                'linkedin' => 'https://linkedin.com/in/vikram-joshi',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Sushma Reddy',
                'position' => 'Volunteer Coordinator',
                'bio' => 'Sushma Reddy coordinates our volunteer programs and manages the hundreds of volunteers who help with temple activities. She ensures that volunteers are properly trained and that their contributions are recognized. Her leadership has built a strong volunteer community.',
                'image' => 'team/sushma-reddy.jpg',
                'email' => 'sushma@temple.com',
                'phone' => '+91-98765-43217',
                'facebook' => 'https://facebook.com/sushmareddy',
                'twitter' => 'https://twitter.com/sushmareddy',
                'linkedin' => 'https://linkedin.com/in/sushma-reddy',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }

        $this->command->info('Team members seeded successfully!');
    }
}

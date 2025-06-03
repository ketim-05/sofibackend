<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Award;

class AwardSeeder extends Seeder
{
    public function run(): void
    {
        $awards = [
            [
                'title' => 'Best Music Producer',
                'organization' => 'Gumma Awards',
                'year' => 2023,
                'image_url' => '/GummaAward.png',
                'description' => 'Recognized for outstanding contribution to Ethiopian music production and innovation in sound engineering.',
                'category' => 'Music Production',
                'is_featured' => true
            ],
            [
                'title' => 'Excellence in Traditional Music Preservation',
                'organization' => 'Adwa Cultural Awards',
                'year' => 2022,
                'image_url' => '/AdwaAward.png',
                'description' => 'Honored for exceptional work in preserving and modernizing traditional Ethiopian musical elements.',
                'category' => 'Cultural Preservation',
                'is_featured' => true
            ],
            [
                'title' => 'Best African Music Producer',
                'organization' => 'AFRIMA (All Africa Music Awards)',
                'year' => 2023,
                'image_url' => '/AfrimaAward.png',
                'description' => 'Continental recognition for outstanding music production work across Africa.',
                'category' => 'International Recognition',
                'is_featured' => true
            ],
            [
                'title' => 'Innovation in Music Technology',
                'organization' => 'Ethiopian Music Industry Awards',
                'year' => 2022,
                'image_url' => '/innovation-award.png',
                'description' => 'Awarded for pioneering use of technology in Ethiopian music production.',
                'category' => 'Technology Innovation',
                'is_featured' => false
            ],
            [
                'title' => 'Outstanding Studio of the Year',
                'organization' => 'East African Music Awards',
                'year' => 2023,
                'image_url' => '/studio-award.png',
                'description' => 'Recognition for Sofi Studio as the leading recording facility in East Africa.',
                'category' => 'Studio Excellence',
                'is_featured' => false
            ],
            [
                'title' => 'Community Impact Award',
                'organization' => 'Ethiopian Arts Council',
                'year' => 2021,
                'image_url' => '/community-award.png',
                'description' => 'Recognized for significant contribution to the development of young Ethiopian artists.',
                'category' => 'Community Service',
                'is_featured' => false
            ]
        ];

        foreach ($awards as $awardData) {
            Award::create($awardData);
        }
    }
}

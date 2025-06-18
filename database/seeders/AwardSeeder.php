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
                'award_image' => 'awards/GummaAward.png',
                'category' => 'Music Production',
                'is_featured' => true
            ],
            [
                'title' => 'Excellence in Traditional Music Preservation',
                'organization' => 'Adwa Cultural Awards',
                'year' => 2022,
                'award_image' => 'awards/AdwaAward.png',
                'category' => 'Cultural Preservation',
                'is_featured' => true
            ],
            [
                'title' => 'Best African Music Producer',
                'organization' => 'AFRIMA (All Africa Music Awards)',
                'year' => 2023,
                'award_image' => 'awards/AfrimaAward.png',
                'category' => 'International Recognition',
                'is_featured' => true
            ],
            [
                'title' => 'Innovation in Music Technology',
                'organization' => 'Ethiopian Music Industry Awards',
                'year' => 2022,
                'award_image' => 'awards/innovation-award.png',
                'category' => 'Technology Innovation',
                'is_featured' => false
            ],
            [
                'title' => 'Outstanding Studio of the Year',
                'organization' => 'East African Music Awards',
                'year' => 2023,
                'award_image' => 'awards/studio-award.png',
                'category' => 'Studio Excellence',
                'is_featured' => false
            ],
            [
                'title' => 'Community Impact Award',
                'organization' => 'Ethiopian Arts Council',
                'year' => 2021,
                'award_image' => 'awards/community-award.png',
                'category' => 'Community Service',
                'is_featured' => false
            ]
        ];

        foreach ($awards as $awardData) {
            Award::create($awardData);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Abraham Wolde',
                'position' => 'Director/Producer',
                'company' => 'Balageru Records',
                'message' => 'My experience with Sultan and the Sofi Records team has been exceptional. Their professionalism and creative vision have elevated our projects to new heights.',
                'image_url' => '/AbrhamWolde.jpeg',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Eden Taye',
                'position' => 'Singer/Producer',
                'company' => 'ETV',
                'message' => 'It has been amazing working with this talented team. They understand the nuances of Ethiopian music while bringing fresh, innovative approaches to production.',
                'image_url' => '/Person1.jpeg',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Bethel Biruk',
                'position' => 'Songwriter/Composer',
                'company' => 'Sofi Records',
                'message' => 'Highly professional and extremely talented! The collaborative environment at Sofi Records has helped me grow as an artist and push creative boundaries.',
                'image_url' => '/Personal2.jpg',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3
            ],
            [
                'name' => 'Michael Tadesse',
                'position' => 'Independent Artist',
                'company' => 'Freelance',
                'message' => 'The quality of production and attention to detail at Sofi Studio is unmatched. They truly care about bringing out the best in every artist.',
                'image_url' => '/testimonial-4.jpg',
                'rating' => 5,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4
            ],
            [
                'name' => 'Sara Kebede',
                'position' => 'Vocalist',
                'company' => 'Independent',
                'message' => 'Working with Sofi Records was a dream come true. They helped me find my unique sound while respecting my artistic vision.',
                'image_url' => '/testimonial-5.jpg',
                'rating' => 4,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5
            ]
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }
    }
}

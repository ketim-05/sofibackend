<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'title' => 'Music Production',
                'description' => 'Professional music production services with state-of-the-art equipment and experienced producers.',
                'detailed_description' => 'Our music production service offers comprehensive support from pre-production to final mastering. We work with artists to develop their sound, arrange compositions, and create professional-quality recordings that meet industry standards. Our studio features the latest digital audio workstations, high-end microphones, and acoustic treatment to ensure optimal recording conditions.',
                'icon' => 'music-note',
                'image_url' => '/services/music-production.jpg',
                'price' => 500.00,
                'price_type' => 'per song',
                'features' => json_encode([
                    'Professional recording studio',
                    'Experienced producers',
                    'Mixing and mastering included',
                    'Unlimited revisions',
                    'High-quality audio files'
                ]),
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Audio Mixing',
                'description' => 'Expert audio mixing to bring your tracks to life with professional sound quality.',
                'detailed_description' => 'Our audio mixing service transforms your raw recordings into polished, radio-ready tracks. We balance all elements of your song, apply professional effects, and ensure your music translates well across all playback systems. Our engineers have years of experience working with various genres and understand the nuances required for each style.',
                'icon' => 'equalizer',
                'image_url' => '/services/audio-mixing.jpg',
                'price' => 200.00,
                'price_type' => 'per song',
                'features' => json_encode([
                    'Professional mixing console',
                    'Industry-standard plugins',
                    'Stereo and surround mixing',
                    'Reference track comparison',
                    'Multiple format delivery'
                ]),
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Mastering',
                'description' => 'Final polish for your tracks with professional mastering services.',
                'detailed_description' => 'Mastering is the final step in music production that ensures your tracks sound their best across all platforms and playback systems. Our mastering engineers use precision tools and trained ears to optimize your music for streaming, radio, and physical media distribution.',
                'icon' => 'volume-up',
                'image_url' => '/services/mastering.jpg',
                'price' => 100.00,
                'price_type' => 'per song',
                'features' => json_encode([
                    'Loudness optimization',
                    'EQ and compression',
                    'Stereo enhancement',
                    'Multiple format output',
                    'Streaming platform optimization'
                ]),
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Recording Studio Rental',
                'description' => 'Rent our professional recording studio for your projects.',
                'detailed_description' => 'Access our fully equipped recording studio for your independent projects. Our studio features professional-grade equipment, acoustic treatment, and a comfortable environment for creativity. Perfect for artists who want to work at their own pace or with their own engineers.',
                'icon' => 'microphone',
                'image_url' => '/services/studio-rental.jpg',
                'price' => 75.00,
                'price_type' => 'per hour',
                'features' => json_encode([
                    'Professional recording equipment',
                    'Acoustic treatment',
                    'Comfortable lounge area',
                    'Parking available',
                    'Flexible scheduling'
                ]),
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Artist Development',
                'description' => 'Comprehensive artist development and career guidance.',
                'detailed_description' => 'Our artist development program provides emerging artists with the tools, knowledge, and connections needed to build successful music careers. We offer mentorship, industry insights, and practical guidance on everything from songwriting to marketing.',
                'icon' => 'star',
                'image_url' => '/services/artist-development.jpg',
                'price' => null,
                'price_type' => 'consultation',
                'features' => json_encode([
                    'One-on-one mentorship',
                    'Industry connections',
                    'Marketing strategy',
                    'Performance coaching',
                    'Career planning'
                ]),
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

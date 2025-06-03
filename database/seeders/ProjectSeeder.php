<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Studio Recording Sessions',
                'description' => 'Professional recording sessions featuring various Ethiopian artists in our state-of-the-art studio.',
                'image_url' => '/Porfolio-Items/porfolioItem-1.png',
                'technologies' => json_encode(['Pro Tools', 'Logic Pro', 'Analog Equipment']), // Convert to JSON
                'client_name' => 'Various Artists',
                'project_url' => null,
                'completion_date' => '2024-12-01',
                'is_featured' => true,
                'status' => 'completed'
            ],
            [
                'title' => 'Collaborative Projects',
                'description' => 'Working with various record labels and artists to create unique musical experiences.',
                'image_url' => '/Balageru.png',
                'technologies' => json_encode(['Digital Audio Workstation', 'MIDI Controllers']), // Convert to JSON
                'client_name' => 'Balageru Records',
                'project_url' => null,
                'completion_date' => '2024-11-15',
                'is_featured' => true,
                'status' => 'completed'
            ],
            [
                'title' => 'Simet Movie Soundtrack',
                'description' => 'Original soundtrack composition and production for the Amharic movie "Simet".',
                'image_url' => '/Porfolio-Items/porfolioItem-3.png',
                'technologies' => json_encode(['Orchestral Arrangement', 'Film Scoring', 'Sound Design']), // Convert to JSON
                'client_name' => 'Simet Film Production',
                'project_url' => null,
                'completion_date' => '2024-10-20',
                'is_featured' => true,
                'status' => 'completed'
            ],
            [
                'title' => 'Artist Collaborations',
                'description' => 'Collaborative projects with emerging and established Ethiopian artists.',
                'image_url' => '/Porfolio-Items/porfolioItem-9.png',
                'technologies' => json_encode(['Live Recording', 'Multi-track Production']), // Convert to JSON
                'client_name' => 'Independent Artists',
                'project_url' => null,
                'completion_date' => '2024-09-30',
                'is_featured' => false,
                'status' => 'completed'
            ],
            [
                'title' => 'Media Coverage Projects',
                'description' => 'Audio production for various media outlets and coverage events.',
                'image_url' => '/Porfolio-Items/porfolioItem-5.png',
                'technologies' => json_encode(['Live Sound', 'Broadcast Audio']), // Convert to JSON
                'client_name' => 'Media Partners',
                'project_url' => null,
                'completion_date' => '2024-08-15',
                'is_featured' => false,
                'status' => 'completed'
            ],
            [
                'title' => 'Traditional Music Fusion',
                'description' => 'Blending traditional Ethiopian instruments with modern production techniques.',
                'image_url' => '/Porfolio-Items/porfolioItem-4.png',
                'technologies' => json_encode(['Traditional Instruments', 'Modern Synthesis', 'Cultural Preservation']), // Convert to JSON
                'client_name' => 'Cultural Heritage Foundation',
                'project_url' => null,
                'completion_date' => '2024-07-10',
                'is_featured' => true,
                'status' => 'completed'
            ]
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }
    }
}

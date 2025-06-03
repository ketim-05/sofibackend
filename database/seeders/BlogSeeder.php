<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Carbon\Carbon;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $blogs = [
            [
                'title' => 'Traditional Tone',
                'subtitle' => 'How Sofi Records is Redefining Ethiopian Music',
                'category' => 'Music Production',
                'author' => 'Sultan Nuri',
                'content' => 'Introduction: A New Era for Ethiopian Music Sofi Records has always been more than just a music label. We see ourselves as curators of culture, innovators in sound, and storytellers of Ethiopian heritage. In this blog post, we\'re excited to share how we\'re redefining the landscape of Ethiopian music with our latest endeavors.',
                'innovation_content' => 'At the heart of Sofi Records lies a deep respect for the rich musical traditions of Ethiopia. Our founder, Sofi, has always believed that to move forward, we must also look back. This philosophy has guided our approach to music production, where we strive to preserve the essence of Ethiopian sounds while introducing fresh, contemporary elements.',
                'img_url' => '/MusicProducer.jpg',
                'slug' => 'traditional-tone-ethiopian-music',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(1),
                'tags' => json_encode(['music', 'ethiopian', 'traditional', 'production']),
                'read_time' => 5,
            ],
            [
                'title' => 'The Future of Music Production',
                'subtitle' => 'Modern Technology Meets Traditional Sounds',
                'category' => 'Technology',
                'author' => 'Sofi Records Team',
                'content' => 'Ethiopia has a rich musical heritage that spans centuries. Today, we are witnessing a renaissance in music production that combines traditional instruments with modern technology. This fusion creates unique sounds that honor the past while embracing the future.',
                'innovation_content' => 'Our state-of-the-art recording studio features both traditional Ethiopian instruments and cutting-edge digital equipment. This combination allows artists to experiment with new sounds while maintaining the authentic essence of Ethiopian music.',
                'img_url' => '/photoOne.png',
                'slug' => 'future-music-production-ethiopia',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(3),
                'tags' => json_encode(['technology', 'production', 'innovation']),
                'read_time' => 7,
            ],
            [
                'title' => 'Artist Spotlight',
                'subtitle' => 'Rising Stars in Ethiopian Music Scene',
                'category' => 'Artists',
                'author' => 'Music Editor',
                'content' => 'Meet the new generation of Ethiopian artists who are making waves both locally and internationally. These talented musicians are bringing fresh perspectives to traditional Ethiopian music while creating entirely new genres.',
                'innovation_content' => 'Each of these artists brings something unique to the table. From incorporating jazz elements into traditional folk songs to creating entirely new fusion genres, they are pushing the boundaries of what Ethiopian music can be.',
                'img_url' => '/PhotoTwo.png',
                'slug' => 'rising-stars-ethiopian-music',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(5),
                'tags' => json_encode(['artists', 'spotlight', 'emerging']),
                'read_time' => 4,
            ],
            [
                'title' => 'Recording Techniques',
                'subtitle' => 'Capturing the Essence of Ethiopian Music',
                'category' => 'Production',
                'author' => 'Sound Engineer',
                'content' => 'Recording Ethiopian music requires a deep understanding of both the technical aspects of sound engineering and the cultural significance of the music being recorded. Our approach focuses on preserving the natural acoustics and emotional depth of each performance.',
                'innovation_content' => 'We use a combination of vintage microphones and modern recording techniques to capture the full spectrum of Ethiopian musical expression. This includes everything from the subtle nuances of traditional vocal techniques to the complex rhythmic patterns of traditional drums.',
                'img_url' => '/PhotoTHree.png',
                'slug' => 'recording-techniques-ethiopian-music',
                'is_published' => true,
                'published_at' => Carbon::now()->subWeek(),
                'tags' => json_encode(['recording', 'techniques', 'engineering']),
                'read_time' => 6,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}

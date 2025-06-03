<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Sheger Concert 2024',
                'description' => 'Experience an unforgettable evening at the Sheger Concert, a celebration of Ethiopian music and culture. This event will feature a diverse lineup of talented artists, each bringing their unique style to the stage.',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(30)->addHours(4),
                'location' => 'Megenagna Cultural Center, Addis Ababa',
                'venue' => 'Main Hall',
                'price' => 200.00,
                'max_attendees' => 500,
                'current_attendees' => 0,
                'image_url' => '/MusicEvent.jpg',
                'organizer' => 'Sofi Records',
                'contact_phone' => '+251987654321',
                'contact_email' => 'events@sofistudio.com',
                'is_featured' => true,
                'status' => 'upcoming'
            ],
            [
                'title' => 'Ethiopian Music Heritage Festival',
                'description' => 'A three-day festival celebrating the rich heritage of Ethiopian music, featuring traditional and contemporary artists from across the country.',
                'start_date' => Carbon::now()->addDays(45),
                'end_date' => Carbon::now()->addDays(47),
                'location' => 'National Theater, Addis Ababa',
                'venue' => 'Multiple Stages',
                'price' => 150.00,
                'max_attendees' => 1000,
                'current_attendees' => 0,
                'image_url' => '/Event1.png',
                'organizer' => 'Ethiopian Cultural Ministry & Sofi Records',
                'contact_phone' => '+251911223344',
                'contact_email' => 'heritage@sofistudio.com',
                'is_featured' => true,
                'status' => 'upcoming'
            ],
            [
                'title' => 'Studio Open House',
                'description' => 'Join us for an exclusive behind-the-scenes tour of Sofi Studio. Meet the team, see our equipment, and learn about our production process.',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15)->addHours(3),
                'location' => 'Sofi Studio, Addis Ababa',
                'venue' => 'Studio Complex',
                'price' => 0.00, // Free event
                'max_attendees' => 50,
                'current_attendees' => 0,
                'image_url' => '/Event2.png',
                'organizer' => 'Sofi Records',
                'contact_phone' => '+251987654321',
                'contact_email' => 'studio@sofistudio.com',
                'is_featured' => false,
                'status' => 'upcoming'
            ],
            [
                'title' => 'Young Artists Showcase',
                'description' => 'A platform for emerging Ethiopian artists to showcase their talent. Featuring performances, networking opportunities, and industry mentorship.',
                'start_date' => Carbon::now()->addDays(60),
                'end_date' => Carbon::now()->addDays(60)->addHours(5),
                'location' => 'Alliance Française, Addis Ababa',
                'venue' => 'Main Auditorium',
                'price' => 100.00,
                'max_attendees' => 200,
                'current_attendees' => 0,
                'image_url' => '/Event3.png',
                'organizer' => 'Sofi Records & Youth Music Initiative',
                'contact_phone' => '+251922334455',
                'contact_email' => 'youth@sofistudio.com',
                'is_featured' => true,
                'status' => 'upcoming'
            ],
            [
                'title' => 'Music Production Workshop',
                'description' => 'Learn the fundamentals of music production from industry professionals. Hands-on workshop covering recording, mixing, and mastering techniques.',
                'start_date' => Carbon::now()->subDays(10), // Past event
                'end_date' => Carbon::now()->subDays(10)->addHours(6),
                'location' => 'Sofi Studio, Addis Ababa',
                'venue' => 'Workshop Room',
                'price' => 250.00,
                'max_attendees' => 20,
                'current_attendees' => 18,
                'image_url' => '/workshop.jpg',
                'organizer' => 'Sofi Records',
                'contact_phone' => '+251987654321',
                'contact_email' => 'workshop@sofistudio.com',
                'is_featured' => false,
                'status' => 'completed'
            ]
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}

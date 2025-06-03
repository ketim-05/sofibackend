<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactMessage;
use Carbon\Carbon;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Dawit Alemayehu',
                'email' => 'dawit@example.com',
                'phone' => '+251911234567',
                'subject' => 'Recording Session Inquiry',
                'message' => 'Hi, I\'m interested in booking a recording session for my upcoming album. Could you please provide information about your rates and availability?',
                'is_read' => false,
                'created_at' => Carbon::now()->subHours(2)
            ],
            [
                'name' => 'Hanan Mohammed',
                'email' => 'hanan@example.com',
                'phone' => '+251922345678',
                'subject' => 'Music Production Services',
                'message' => 'I\'m a songwriter looking for professional music production services. I have 5 songs that need full production. What packages do you offer?',
                'is_read' => true,
                'created_at' => Carbon::now()->subDays(1)
            ],
            [
                'name' => 'Yonas Tadesse',
                'email' => 'yonas@example.com',
                'phone' => '+251933456789',
                'subject' => 'Collaboration Opportunity',
                'message' => 'Hello Sultan, I represent a group of traditional musicians who would like to collaborate on a modern fusion project. Are you interested in discussing this opportunity?',
                'is_read' => true,
                'created_at' => Carbon::now()->subDays(3)
            ],
            [
                'name' => 'Meron Bekele',
                'email' => 'meron@example.com',
                'phone' => '+251944567890',
                'subject' => 'Studio Tour Request',
                'message' => 'I\'m a music student and would love to tour your studio to learn about professional music production. Is this possible?',
                'is_read' => false,
                'created_at' => Carbon::now()->subHours(6)
            ],
            [
                'name' => 'Tekle Hailu',
                'email' => 'tekle@example.com',
                'phone' => '+251955678901',
                'subject' => 'Mixing and Mastering',
                'message' => 'I have recorded some tracks at home and need professional mixing and mastering. Can you help with this? What are your rates?',
                'is_read' => false,
                'created_at' => Carbon::now()->subMinutes(30)
            ],
            [
                'name' => 'Selamawit Girma',
                'email' => 'selam@example.com',
                'phone' => '+251966789012',
                'subject' => 'Event Performance',
                'message' => 'We\'re organizing a cultural event and would like to invite you to perform or provide music services. Please let us know if you\'re available.',
                'is_read' => true,
                'created_at' => Carbon::now()->subDays(5)
            ]
        ];

        foreach ($messages as $messageData) {
            ContactMessage::create($messageData);
        }
    }
}

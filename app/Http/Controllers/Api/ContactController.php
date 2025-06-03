<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\SiteAnalytics;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse
    {
        try {
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject ?? 'General Inquiry',
                'message' => $request->message,
                'is_read' => false
            ]);

            SiteAnalytics::recordContactSubmission();

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your message! We will get back to you soon.',
                'data' => [
                    'id' => $contactMessage->id,
                    'name' => $contactMessage->name,
                    'subject' => $contactMessage->subject
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function info(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'email' => 'info@sofistudio.com',
                'phone' => '+251 911 123 456',
                'address' => 'Addis Ababa, Ethiopia',
                'business_hours' => [
                    'monday_friday' => '9:00 AM - 6:00 PM',
                    'saturday' => '10:00 AM - 4:00 PM',
                    'sunday' => 'Closed'
                ],
                'social_media' => [
                    'facebook' => 'https://facebook.com/sofistudio',
                    'instagram' => 'https://instagram.com/sofistudio',
                    'twitter' => 'https://twitter.com/sofistudio',
                    'youtube' => 'https://youtube.com/sofistudio'
                ]
            ]
        ]);
    }
}

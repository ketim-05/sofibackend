<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status'); // read, unread, all
        
        $query = ContactMessage::orderBy('created_at', 'desc');
        
        if ($status === 'read') {
            $query->where('is_read', true);
        } elseif ($status === 'unread') {
            $query->where('is_read', false);
        }
        
        $messages = $query->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Display the specified contact message
     */
    public function show(ContactMessage $contactMessage): JsonResponse
    {
        // Mark as read when viewed
        if (!$contactMessage->is_read) {
            $contactMessage->markAsRead();
        }
        
        return response()->json([
            'success' => true,
            'data' => $contactMessage
        ]);
    }

    /**
     * Mark message as read
     */
    public function markAsRead(ContactMessage $contactMessage): JsonResponse
    {
        $contactMessage->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Message marked as read',
            'data' => $contactMessage
        ]);
    }

    /**
     * Mark message as unread
     */
    public function markAsUnread(ContactMessage $contactMessage): JsonResponse
    {
        $contactMessage->update(['is_read' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Message marked as unread',
            'data' => $contactMessage
        ]);
    }

    /**
     * Remove the specified contact message
     */
    public function destroy(ContactMessage $contactMessage): JsonResponse
    {
        $contactMessage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message deleted successfully'
        ]);
    }

    /**
     * Get unread messages count
     */
    public function unreadCount(): JsonResponse
    {
        $count = ContactMessage::unread()->count();

        return response()->json([
            'success' => true,
            'data' => ['count' => $count]
        ]);
    }
}

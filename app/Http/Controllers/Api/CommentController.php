<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function index(Blog $blog): JsonResponse
    {
        $comments = $blog->approvedComments()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'name' => $comment->full_name,
                    'message' => $comment->message,
                    'date' => $comment->created_at->diffForHumans()
                ];
            });
            
        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    public function store(StoreCommentRequest $request, Blog $blog): JsonResponse
    {
        $comment = $blog->comments()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'message' => $request->message,
            'is_approved' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment submitted successfully! It will be visible after approval.',
            'data' => [
                'id' => $comment->id,
                'name' => $comment->full_name,
                'message' => $comment->message
            ]
        ], 201);
    }
}

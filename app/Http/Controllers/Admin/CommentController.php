<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Display a listing of comments
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $status = $request->get('status'); // approved, pending, all
        
        $query = Comment::with('blog')->orderBy('created_at', 'desc');
        
        if ($status === 'approved') {
            $query->where('is_approved', true);
        } elseif ($status === 'pending') {
            $query->where('is_approved', false);
        }
        
        $comments = $query->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $comments
        ]);
    }

    /**
     * Display the specified comment
     */
    public function show(Comment $comment): JsonResponse
    {
        $comment->load('blog');
        
        return response()->json([
            'success' => true,
            'data' => $comment
        ]);
    }

    /**
     * Approve a comment
     */
    public function approve(Comment $comment): JsonResponse
    {
        $comment->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Comment approved successfully',
            'data' => $comment
        ]);
    }

    /**
     * Reject/Unapprove a comment
     */
    public function reject(Comment $comment): JsonResponse
    {
        $comment->update(['is_approved' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Comment rejected successfully',
            'data' => $comment
        ]);
    }

    /**
     * Remove the specified comment
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
}

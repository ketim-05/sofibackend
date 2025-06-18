<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of all blogs (including unpublished)
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search');
        $status = $request->get('status'); // published, draft, all
        
        $query = Blog::with('comments')->orderBy('created_at', 'desc');
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        
        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }
        
        $blogs = $query->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $blogs
        ]);
    }

    /**
     * Store a newly created blog
     */
    public function store(Request $request): JsonResponse
    {
        // 1. VAlidation




//you can skip 2,3,4 if you don't want change the img name
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'author' => 'nullable|string|max:100',
            'content' => 'required|string',
            'innovation_content' => 'nullable|string',
            'img_url' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tags' => 'nullable|array',
            'read_time' => 'nullable|integer|min:1',
            'is_published' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
// 2. get File
$post_img = $request->file('img_url');

// 3. get File Extention
$img_ext = $post_img->getClientOriginalExtension();

// 4. Change image name by Random Name
$img_name = time() . '.' . $img_ext;

// 5. Create Image Storage Path
$img_path = 'uploads/img/blog/';

// 6. Upload Image in Specified path
$post_img->move('uploads/img/blog/', $img_name);

// 7. Reassign in Validate Variable

$img_url = $img_path . $img_name;


        $blog = Blog::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'category' => $request->category,
            'author' => $request->author ?? 'Sultan Nuri',
            'content' => $request->content,
            'innovation_content' => $request->innovation_content,
            'img_url' =>$img_url,
            'slug' => Str::slug($request->title),
            'tags' => $request->tags,
            'read_time' => $request->read_time ?? 5,
            'is_published' => $request->is_published ?? false,
            'published_at' => $request->is_published ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Blog created successfully',
            'data' => $blog
        ], 201);
    }

    /**
     * Display the specified blog
     */
    public function show(Blog $blog): JsonResponse
    {
        $blog->load('comments');
        
        return response()->json([
            'success' => true,
            'data' => $blog
        ]);
    }
    public function showImage($id) {
        $blog = Blog::find($id);

        return [
            "blog_img" => $blog->img_url
        ];
    }
    /**
     * Update the specified blog
     */
    public function update(Request $request, Blog $blog): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'required|string|max:100',
            'author' => 'nullable|string|max:100',
            'content' => 'required|string',
            'innovation_content' => 'nullable|string',
            'img_url' => 'nullable|url',
            'tags' => 'nullable|array',
            'read_time' => 'nullable|integer|min:1',
            'is_published' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $blog->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'category' => $request->category,
            'author' => $request->author ?? 'Sultan Nuri',
            'content' => $request->content,
            'innovation_content' => $request->innovation_content,
            'img_url' => $request->img_url,
            'slug' => $request->title !== $blog->title ? Str::slug($request->title) : $blog->slug,
            'tags' => $request->tags,
            'read_time' => $request->read_time ?? 5,
            'is_published' => $request->is_published ?? false,
            'published_at' => $request->is_published && !$blog->published_at ? now() : $blog->published_at
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Blog updated successfully',
            'data' => $blog
        ]);
    }

    /**
     * Remove the specified blog
     */
    public function destroy(Blog $blog): JsonResponse
    {
        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog deleted successfully'
        ]);
    }

    /**
     * Toggle blog publication status
     */
    public function togglePublish(Blog $blog): JsonResponse
    {
        $blog->update([
            'is_published' => !$blog->is_published,
            'published_at' => !$blog->is_published ? now() : $blog->published_at
        ]);

        $status = $blog->is_published ? 'published' : 'unpublished';

        return response()->json([
            'success' => true,
            'message' => "Blog {$status} successfully",
            'data' => $blog
        ]);
    }
}

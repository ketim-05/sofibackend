<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AwardController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\AwardController as AdminAwardController;
use App\Http\Controllers\Admin\NewsletterSubscriptionController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;

// Sanctum user route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes (no authentication required)
Route::prefix('v1')->middleware(['api'])->group(function () {
    // Public blogs
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/featured', [BlogController::class, 'featured']);
    Route::get('/blogs/{id}', [BlogController::class, 'show']);

    // Public projects
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/featured', [ProjectController::class, 'featured']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::get('/blog/{id}', [AdminBlogController::class, 'showImage']);

    // Public services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);

    // Public events
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/upcoming', [EventController::class, 'upcoming']);
    Route::get('/events/{id}', [EventController::class, 'show']);

    // Public testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/testimonials/featured', [TestimonialController::class, 'featured']);

    // Public clients
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);

    // Public awards
    Route::get('/awards', [AwardController::class, 'index']);
    Route::get('/awards/featured', [AwardController::class, 'featured']);

    // Public contact form
    Route::post('/contact', [ContactMessageController::class, 'store']);

    // Public comments
    Route::post('/blogs/{blog}/comments', [CommentController::class, 'store']);
});

// Protected Admin API routes (authentication required)
Route::prefix('v1/admin')->middleware(['api', 'auth:sanctum', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    // Auth routes
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware(['auth:sanctum', \App\Http\Middleware\AdminMiddleware::class]);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/recent-activity', [DashboardController::class, 'recentActivity']);
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics']);

    // Admin blog management
    Route::apiResource('blogs', AdminBlogController::class);
    
    // Admin event management
    Route::apiResource('events', AdminEventController::class);
    Route::patch('events/{event}/toggle-featured', [AdminEventController::class, 'toggleFeatured']);
    Route::patch('events/{event}/toggle-active', [AdminEventController::class, 'toggleActive']);

    // Admin project management
    Route::apiResource('projects', AdminProjectController::class);

    // Admin testimonial management
    Route::apiResource('testimonials', AdminTestimonialController::class);
    Route::patch('/testimonials/{testimonial}/toggle-featured', [AdminTestimonialController::class, 'toggleFeatured']);

    // Admin client management
    Route::apiResource('clients', AdminClientController::class);

    // Admin award management
    Route::apiResource('awards', AdminAwardController::class);

    // Admin newsletter subscriptions
    Route::get('/newsletter-subscriptions', [NewsletterSubscriptionController::class, 'index']);
    Route::get('/newsletter-subscriptions/{subscription}', [NewsletterSubscriptionController::class, 'show']);
    Route::patch('/newsletter-subscriptions/{subscription}/status', [NewsletterSubscriptionController::class, 'updateStatus']);
    Route::delete('/newsletter-subscriptions/{subscription}', [NewsletterSubscriptionController::class, 'destroy']);
    Route::get('/newsletter-subscriptions-stats', [NewsletterSubscriptionController::class, 'stats']);
    Route::get('/newsletter-subscriptions-export', [NewsletterSubscriptionController::class, 'export']);

    // Admin comment management
    Route::apiResource('comments', AdminCommentController::class)->except(['store', 'update']);
    Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve']);
    Route::patch('/comments/{comment}/reject', [AdminCommentController::class, 'reject']);
    Route::post('/comments/bulk-action', [AdminCommentController::class, 'bulkAction']);

    // Admin contact messages
    Route::get('/contact-messages', [AdminContactMessageController::class, 'index']);
    Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show']);
    Route::patch('/contact-messages/{contactMessage}/read', [AdminContactMessageController::class, 'markAsRead']);
    Route::delete('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy']);
});

// Test admin middleware route
Route::get('/v1/test-admin-middleware', function () {
    return response()->json(['message' => 'Admin middleware test successful!']);
})->middleware(['auth:sanctum', \App\Http\Middleware\AdminMiddleware::class]);

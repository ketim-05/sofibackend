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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes
Route::prefix('v1')->group(function () {
    // Blogs
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/featured', [BlogController::class, 'featured']);
    Route::get('/blogs/{id}', [BlogController::class, 'show']);
    
    // Projects
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/featured', [ProjectController::class, 'featured']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    
    // Services
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);
    
    // Events
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/upcoming', [EventController::class, 'upcoming']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    
    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::get('/testimonials/featured', [TestimonialController::class, 'featured']);
    
    // Clients
    Route::get('/clients', [ClientController::class, 'index']);
    
    // Awards
    Route::get('/awards', [AwardController::class, 'index']);
    Route::get('/awards/featured', [AwardController::class, 'featured']);
    
    // Contact Messages (POST only for public)
    Route::post('/contact', [ContactMessageController::class, 'store']);
    
    // Comments
    Route::post('/blogs/{blog}/comments', [CommentController::class, 'store']);
});

// Admin Authentication Routes
Route::prefix('v1/admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    
    // Protected admin routes
    Route::middleware(['auth:sanctum', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
        // Auth routes
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        
        // Dashboard
        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
        Route::get('/dashboard/recent-activity', [DashboardController::class, 'recentActivity']);
        Route::get('/dashboard/analytics', [DashboardController::class, 'analytics']);
        
        // Blog Management
        Route::apiResource('blogs', AdminBlogController::class);
        
        // Event Management
        Route::apiResource('events', AdminEventController::class);
        
        // Project Management
        Route::apiResource('projects', AdminProjectController::class);
        
        // Testimonial Management
        Route::apiResource('testimonials', AdminTestimonialController::class);
        Route::patch('/testimonials/{testimonial}/toggle-featured', [AdminTestimonialController::class, 'toggleFeatured']);
        
        // Client Management
        Route::apiResource('clients', AdminClientController::class);
        
        // Award Management
        Route::apiResource('awards', AdminAwardController::class);
        
        // Newsletter Subscriptions
        Route::get('/newsletter-subscriptions', [NewsletterSubscriptionController::class, 'index']);
        Route::get('/newsletter-subscriptions/{subscription}', [NewsletterSubscriptionController::class, 'show']);
        Route::patch('/newsletter-subscriptions/{subscription}/status', [NewsletterSubscriptionController::class, 'updateStatus']);
        Route::delete('/newsletter-subscriptions/{subscription}', [NewsletterSubscriptionController::class, 'destroy']);
        Route::get('/newsletter-subscriptions-stats', [NewsletterSubscriptionController::class, 'stats']);
        Route::get('/newsletter-subscriptions-export', [NewsletterSubscriptionController::class, 'export']);
        
        // Comment Management
        Route::apiResource('comments', AdminCommentController::class)->except(['store', 'update']);
        Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve']);
        Route::patch('/comments/{comment}/reject', [AdminCommentController::class, 'reject']);
        Route::post('/comments/bulk-action', [AdminCommentController::class, 'bulkAction']);
        
        // Contact Messages
        Route::get('/contact-messages', [AdminContactMessageController::class, 'index']);
        Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show']);
        Route::patch('/contact-messages/{contactMessage}/read', [AdminContactMessageController::class, 'markAsRead']);
        Route::delete('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy']);
    });
});

// Temporary test route for admin middleware
Route::get('/v1/test-admin-middleware', function () {
    return response()->json(['message' => 'Admin middleware test successful!']);
})->middleware('admin');

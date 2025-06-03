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

// Protected admin routes
Route::middleware('auth:sanctum')->prefix('v1/admin')->group(function () {
    // Blogs
    Route::post('/blogs', [BlogController::class, 'store']);
    Route::put('/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);
    
    // Contact Messages
    Route::get('/contact-messages', [ContactMessageController::class, 'index']);
    Route::get('/contact-messages/{id}', [ContactMessageController::class, 'show']);
    Route::delete('/contact-messages/{id}', [ContactMessageController::class, 'destroy']);
    
    // Add other admin routes as needed...
});

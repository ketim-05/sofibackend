<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Blog;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = Blog::all();
        
        $comments = [
            [
                'first_name' => 'Abraham',
                'last_name' => 'Wolde',
                'email' => 'abraham@example.com',
                'message' => 'Amazing work! The way you blend traditional Ethiopian sounds with modern production is truly inspiring.',
                'is_approved' => true
            ],
            [
                'first_name' => 'Eden',
                'last_name' => 'Taye',
                'email' => 'eden@example.com',
                'message' => 'I love how you preserve our cultural heritage while pushing creative boundaries. Keep up the excellent work!',
                'is_approved' => true
            ],
            [
                'first_name' => 'Bethel',
                'last_name' => 'Biruk',
                'email' => 'bethel@example.com',
                'message' => 'The production quality at Sofi Studio is world-class. Thank you for elevating Ethiopian music!',
                'is_approved' => true
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Tadesse',
                'email' => 'michael@example.com',
                'message' => 'This is exactly what Ethiopian music needs. Innovation without losing our roots.',
                'is_approved' => true
            ],
            [
                'first_name' => 'Sara',
                'last_name' => 'Kebede',
                'email' => 'sara@example.com',
                'message' => 'When will you be releasing more content like this? Can\'t wait to hear what\'s next!',
                'is_approved' => false // Pending approval
            ]
        ];

        foreach ($blogs as $blog) {
            // Add 2-4 random comments to each blog
            $numComments = rand(2, 4);
            for ($i = 0; $i < $numComments; $i++) {
                $commentData = $comments[array_rand($comments)];
                $commentData['blog_id'] = $blog->id;
                Comment::create($commentData);
            }
        }
    }
}

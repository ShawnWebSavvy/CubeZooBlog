<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Get all users and tags
        $users = User::all();
        $tags = Tag::all();

        // Create some posts
        foreach ($users as $user) {
            Post::create([
                'title' => 'Sample Post by ' . $user->name,
                'body' => 'This is a sample post content.',
                'user_id' => $user->id,
                'status' => 'published',
                'published_at' => '2024-10-10 00:00:00'

            ])->tags()->attach($tags->random(2)); // Attach 2 random tags to the post
        }
    }
}
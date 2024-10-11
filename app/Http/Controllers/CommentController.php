<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Validate the request
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Create the comment
        $post->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);

        // Redirect back to the post page
        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully.');
    }
}

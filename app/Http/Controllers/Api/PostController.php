<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    // Create a new post
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|string|in:draft,published', // Optional: Validate status
            'image' => 'nullable|image|max:2048', // Optional: Validate image upload
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Create the post
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'status' => $request->status,
            'image' => $imagePath,
            'user_id' => auth()->id(),
        ]);

        return response()->json($post, 201);
    }

    public function destroy(Post $post)
    {
        // Check if the authenticated user is authorized to delete the post
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();
        return response()->json(null, 204);
    }
}
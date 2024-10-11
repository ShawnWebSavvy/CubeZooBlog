<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tagSearch = $request->input('tag');

        $query = Post::with('user', 'tags', 'comments.user')
            ->where('status', 'published')
            ->where('published_at', '<=', now());

        // Search by post title or body
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // Search by tags
        if ($tagSearch) {
            $query->whereHas('tags', function ($q) use ($tagSearch) {
                $q->where('name', 'like', "%{$tagSearch}%");
            });
        }

        $posts = $query->paginate(10);

        return view('posts.index', compact('posts', 'search', 'tagSearch'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate(['comment' => 'required|string']);
        $post->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'image|nullable|max:1999',
            'status' => 'required|in:draft,published',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'date',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imagePath,
            'status' => $request->status,
            //'published_at' => $request->status === 'published' ? now() : null,
            'published_at' => $request->published_at,
        ]);

        // Attach existing tags
        if ($request->filled('tags')) {
            $post->tags()->attach($request->tags);
        }

        // Create new tags
        if ($request->filled('new_tags')) {
            $newTagNames = explode(',', $request->new_tags);
            foreach ($newTagNames as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    // Check if the tag already exists, if not, create it
                    $tag = Tag::firstOrCreate(['name' => $tagName]);
                    $post->tags()->attach($tag->id);
                }
            }
        }

        // Log activity -- Admin
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'post_id' => $post->id,
            'description' => 'Post created: ' . $post->title,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'image|nullable|max:1999',
            'status' => 'required|in:draft,published',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image);
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $post->image;
        }

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imagePath,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        $post->tags()->sync($request->tags);

        // Log activity -Admin
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'post_id' => $post->id,
            'description' => 'Post updated: ' . $post->title,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        // Log activity - Admin
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'post_id' => $post->id,
            'description' => 'Post deleted: ' . $post->title,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}

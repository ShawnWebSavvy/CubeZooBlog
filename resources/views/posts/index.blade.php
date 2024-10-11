@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Posts</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-4">Create New Post</a>

    <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="search" class="form-label">Search Posts:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Search by title or body" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="tag" class="form-label">Search by Tag:</label>
                <input type="text" name="tag" id="tag" value="{{ request('tag') }}" placeholder="Search by tag name"
                    class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-outline-secondary mt-3">Search</button>
    </form>

    <div class="list-group">
        @foreach ($posts as $post)
            <div class="list-group-item mb-4">
                <h3>
                    <a href="{{ route('posts.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a>
                    <span
                        class="badge bg-{{ $post->is_published ? 'success' : 'warning' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span>
                </h3>

                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>
                @endcan
                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                @endcan

                <h4 class="mt-4">Comments:</h4>
                <ul class="list-group">
                    @forelse ($post->comments as $comment)
                        <li class="list-group-item">
                            <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}
                        </li>
                    @empty
                        <li class="list-group-item">No comments yet.</li>
                    @endforelse
                </ul>

                <h4 class="mt-4">Tags:</h4>
                <ul class="list-inline">
                    @forelse($post->tags as $tag)
                        <li class="list-inline-item badge bg-secondary">{{ $tag->name }}</li>
                    @empty
                        <li>No tags yet.</li>
                    @endforelse
                </ul>

                @auth
                    <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment" rows="3" required class="form-control"
                                placeholder="Add a comment..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Comment</button>
                    </form>
                @else
                    <p class="mt-4">You must be logged in to comment.</p>
                @endauth

            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
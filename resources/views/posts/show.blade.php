@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>{{ $post->title }}</h1>
    <p class="text-muted">by {{ $post->user->name }}</p>

    <p>{{ $post->body }}</p>

    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid mb-3">
    @endif

    <h2>Comments</h2>

    @auth
        <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="comment" class="form-label">Add a comment:</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </form>
    @else
        <p class="text-danger">You must be logged in to comment.</p>
    @endauth

    <ul class="list-group">
        @foreach ($post->comments as $comment)
            <li class="list-group-item">
                <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Create Post</h1>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="published_at" class="form-label">Schedule Publish Date & Time</label>
            <input type="datetime-local" name="published_at" id="published_at" class="form-control"
                value="{{ old('published_at', $post->published_at ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="tags" class="form-label">Select Existing Tags:</label>
            <select name="tags[]" id="tags" class="form-select" multiple>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="new_tags" class="form-label">Create New Tags (comma-separated):</label>
            <input type="text" name="new_tags" id="new_tags" class="form-control" placeholder="Tag1, Tag2, Tag3">
        </div>

        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Activity Log</h1>

    <!-- Activity Log Table -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">User</th>
                <th scope="col">Action</th>
                <th scope="col">Post</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ ucfirst($log->action) }}</td>
                    <td><a href="{{ route('posts.show', $log->post->id) }}">{{ $log->post->title }}</a></td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $logs->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
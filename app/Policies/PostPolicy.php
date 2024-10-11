<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    // Allow admin and author to create posts
    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'author']);
    }

    // Allow users to update their own posts or admins to update any post
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->role === 'admin';
    }

    // Allow users to delete their own posts or admins to delete any post
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id || $user->role === 'admin';
    }

    // New method to manage posts
    public function manage(User $user)
    {
        return in_array($user->role, ['admin', 'author']);
    }
}
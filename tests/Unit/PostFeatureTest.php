<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_a_post()
    {
        $user = User::factory()->create(); // Create a test user
        $this->actingAs($user);

        $postData = [
            'title' => 'Test Post',
            'body' => 'This is a test body.',
            'status' => 'published',
        ];

        $response = $this->postJson('/api/posts', $postData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', $postData);
    }

    /** @test */
    public function an_authenticated_user_can_delete_their_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(204);
        //$this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }

    /** @test */
    public function an_authenticated_user_cannot_delete_other_users_posts()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        $post = Post::factory()->create(['user_id' => $user2->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(403);
    }
}
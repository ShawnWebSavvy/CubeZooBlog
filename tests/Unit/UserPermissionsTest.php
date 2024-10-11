<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPermissionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_if_user_is_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['role' => 'author']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($author->isAdmin());
    }

    /** @test */
    public function it_checks_user_permissions()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $author = User::factory()->create(['role' => 'author']);

        $this->assertTrue($admin->can('manage-posts'));
        $this->assertFalse($author->can('manage-posts'));
    }
}
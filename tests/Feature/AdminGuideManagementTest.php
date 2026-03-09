<?php

namespace Tests\Feature;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminGuideManagementTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::factory()->create([
            'is_system_admin' => true,
        ]);
    }

    public function test_admin_can_create_guide_and_auto_slug_is_unique(): void
    {
        $admin = $this->adminUser();

        Guide::create([
            'title' => 'GST Filing Guide',
            'slug' => 'gst-filing-guide',
            'category' => 'tax',
            'steps' => '1. Collect docs',
            'status' => 'published',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.guides.store'), [
            'title' => 'GST Filing Guide',
            'category' => 'tax',
            'steps' => "1. Step one\n2. Step two",
            'status' => 'draft',
        ]);

        $response->assertRedirect(route('admin.guides.index'));

        $this->assertDatabaseHas('guides', [
            'title' => 'GST Filing Guide',
            'slug' => 'gst-filing-guide-2',
            'status' => 'draft',
        ]);
    }

    public function test_admin_can_filter_guides_by_status(): void
    {
        $admin = $this->adminUser();

        Guide::create([
            'title' => 'Draft Guide',
            'slug' => 'draft-guide',
            'category' => 'general',
            'steps' => 'draft steps',
            'status' => 'draft',
        ]);

        Guide::create([
            'title' => 'Published Guide',
            'slug' => 'published-guide',
            'category' => 'general',
            'steps' => 'published steps',
            'status' => 'published',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.guides.index', ['status' => 'published']));

        $response->assertOk();
        $response->assertSee('Published Guide');
        $response->assertDontSee('Draft Guide');
    }
}

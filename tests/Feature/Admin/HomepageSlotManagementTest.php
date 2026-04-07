<?php

namespace Tests\Feature\Admin;

use App\Models\HomepageSlot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageSlotManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_homepage_slot_admin_page(): void
    {
        $response = $this->get('/admin/homepage-slots');

        $response->assertRedirect('/login');
    }

    public function test_non_admin_user_cannot_access_homepage_slot_admin_page(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/homepage-slots');

        $response->assertRedirect('/');
    }

    public function test_admin_can_view_homepage_slot_admin_page_and_default_slots_are_created(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/homepage-slots');

        $response->assertOk();
        $response->assertSee('Pengaturan Homepage Berbasis Slot');
        $this->assertSame(10, HomepageSlot::count());
    }
}

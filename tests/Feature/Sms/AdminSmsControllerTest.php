<?php

namespace Tests\Feature\Sms;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature tests for the AdminSmsController routes.
 *
 * Tests page access, form submission, and API endpoints.
 */
class AdminSmsControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user with admin role
        $this->admin = User::factory()->create([
            'name'    => 'Admin',
            'MOP'     => '01012345678',
            'isAdmin' => true,
        ]);
    }

    public function test_sms_index_page_requires_auth(): void
    {
        $response = $this->get(route('sitemanagement.sms.index'));
        $response->assertRedirect();
    }

    public function test_sms_create_page_loads_for_admin(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->get(route('sitemanagement.sms.create'));
        $response->assertStatus(200);
        $response->assertSee('إرسال رسائل SMS');
    }

    public function test_sms_store_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->post(route('sitemanagement.sms.store'), []);
        $response->assertSessionHasErrors(['message_template', 'send_type']);
    }

    public function test_sms_store_validates_message_length(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->post(route('sitemanagement.sms.store'), [
                             'message_template' => 'ab',
                             'send_type'        => 'all_users',
                         ]);
        $response->assertSessionHasErrors(['message_template']);
    }

    public function test_sms_store_requires_user_ids_for_selected_type(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
                         ->post(route('sitemanagement.sms.store'), [
                             'message_template' => 'مرحبا {name}',
                             'send_type'        => 'selected_users',
                         ]);
        $response->assertSessionHasErrors(['user_ids']);
    }

    public function test_sms_store_creates_batch_for_all_users(): void
    {
        config(['sms.default_provider' => 'mock']);
        User::factory()->count(3)->create(['MOP' => '01112345678']);

        $response = $this->actingAs($this->admin, 'admin')
                         ->post(route('sitemanagement.sms.store'), [
                             'message_template' => 'مرحبا {name}',
                             'send_type'        => 'all_users',
                         ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('sms_batches', [
            'send_type'        => 'all_users',
            'message_template' => 'مرحبا {name}',
        ]);
    }

    public function test_search_users_returns_json(): void
    {
        User::factory()->create(['name' => 'TestUser', 'MOP' => '01012345678']);

        $response = $this->actingAs($this->admin, 'admin')
                         ->get(route('sitemanagement.sms.searchUsers', ['search' => 'TestUser']));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'TestUser']);
    }

    public function test_preview_recipients_returns_counts(): void
    {
        User::factory()->create(['MOP' => '01012345678']);
        User::factory()->create(['MOP' => 'invalid']);

        $response = $this->actingAs($this->admin, 'admin')
                         ->post(route('sitemanagement.sms.previewRecipients'), [
                             'send_type' => 'all_users',
                         ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['total', 'valid', 'invalid']);
    }
}

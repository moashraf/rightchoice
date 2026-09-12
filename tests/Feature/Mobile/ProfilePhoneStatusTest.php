<?php

namespace Tests\Feature\Mobile;

use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ProfilePhoneStatusTest extends MobileTestCase
{
    public function test_phone_status_requires_authentication(): void
    {
        $this->getJson('/api/profile/phone-status')->assertUnauthorized();
    }

    public function test_it_reports_that_phone_is_required_when_phone_is_null(): void
    {
        $user = User::create([
            'name' => 'Social User',
            'email' => 'social@example.com',
            'status' => 1,
            'MOP' => null,
        ]);

        Sanctum::actingAs($user);

        $this->getJson('/api/profile/phone-status')
            ->assertOk()
            ->assertJsonPath('data.has_phone', false)
            ->assertJsonPath('data.requires_phone', true)
            ->assertJsonPath('data.phone', null)
            ->assertJsonPath('message', 'رقم الهاتف مطلوب. يرجى إضافة رقم هاتف للمتابعة.');
    }

    public function test_it_treats_a_blank_phone_as_missing(): void
    {
        $user = User::create([
            'name' => 'Blank Phone User',
            'email' => 'blank@example.com',
            'status' => 1,
            'MOP' => '   ',
        ]);

        Sanctum::actingAs($user);

        $this->getJson('/api/profile/phone-status')
            ->assertOk()
            ->assertJsonPath('data.has_phone', false)
            ->assertJsonPath('data.requires_phone', true)
            ->assertJsonPath('data.phone', null)
            ->assertJsonPath('message', 'رقم الهاتف مطلوب. يرجى إضافة رقم هاتف للمتابعة.');
    }

    public function test_it_reports_an_existing_phone_number(): void
    {
        $user = User::create([
            'name' => 'Phone User',
            'email' => 'phone@example.com',
            'status' => 1,
            'MOP' => '01012345678',
        ]);

        Sanctum::actingAs($user);

        $this->getJson('/api/profile/phone-status')
            ->assertOk()
            ->assertJsonPath('data.has_phone', true)
            ->assertJsonPath('data.requires_phone', false)
            ->assertJsonPath('data.phone', '01012345678')
            ->assertJsonPath('message', 'رقم الهاتف مسجل بالفعل.');
    }
}

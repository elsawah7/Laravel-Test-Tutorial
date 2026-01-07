<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

test('that_user_cannot_logout_if_not_logged_in', function () {
    $response = $this->get('/logout');
    $response->assertStatus(302);
    $response->assertRedirect('/login');
});

test('that_user_can_logout', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user);
    $response = $this->get('/logout');
    $response->assertStatus(302);
    $this->assertGuest();
});

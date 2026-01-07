<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('that_user_acn_access_login_page', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
    $response->assertViewIs('login');
    $response->assertSeeInOrder([
        '<form',
        'name="email"',
        'name="password"',
        'type="submit"',
        '</form>',
    ]);
});


test('that_user_cannot_login_with_no_data', function () {
    $response = $this->post('/login', []);
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['email', 'password']);
});

test('that_user_cannot_login_with_invalid_email', function () {
    $response = $this->post('/login', [
        'email' => 'invalid_email',
        'password' => 'password',
    ]);
    $response->assertStatus(302);
    $response->assertSessionHasErrors(['email']);
});
test('that_can_login_with_valid_data', function () {
    $user = User::create([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'johndoe@example.com',
        'password' => 'password',
    ]);
    $response->assertStatus(302);
    $this->assertAuthenticated();
});

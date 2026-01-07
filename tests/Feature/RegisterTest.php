<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('register_form_is_displayed', function () {
    $response = $this->get('/register');
    $response->assertStatus(200);
    $response->assertViewIs('register');
    $response->assertSeeInOrder([
        '<form',
        'name="name"',
        'name="email"',
        'name="password"',
        'name="password_confirmation"',
        '<button',
        '</form>',
    ]);
});

test('user_cannot_register_with_no_data', function () {

    $response = $this->post('/register');
    $response->assertSessionHasErrors(['name', 'email', 'password']);
});

test('user_cannot_register_with_invalid_email', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'johndoe',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $response->assertSessionHasErrors(['email']);
});

test('user_cannot_register_with_unique_email', function () {
    User::factory()->create(['email' => 'test@example.com']);
    $response = $this->post('/register', [
        'name' => 'test user',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $response->assertSessionHasErrors(['email']);
});



test('user_cannot_register_with_invalid_password', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => '1245',
        'password_confirmation' => '1245',
    ]);
    $response->assertSessionHasErrors(['password']);
});

test('user_can_register_with_valid_data', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $response->assertSessionDoesntHaveErrors();
    $this->assertDataBaseHas('users', [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
    ]);
    $response->assertStatus(201);
});

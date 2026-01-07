<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('that_users_table_has_no_records', function () {
    $this->assertDatabaseCount('users', 0);
    $this->assertDatabaseEmpty('users');
});

test('that_users_table_has_records', function () {
    User::create([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password',
    ]);
    $this->assertDatabaseCount('users', 1);
});

test('that_users_table_has_records_after_seed', function () {
    $this->seed();
    $this->assertDatabaseCount('users', 1);
});

test('that_user_can_be_soft_deleted', function () {
    $user = User::create([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password',
    ]);
    $this->assertDatabaseHas('users', ['id' => $user->id]);
    $user->delete();
    $this->assertSoftDeleted($user);
    $this->assertDatabaseHas('users', ['id' => $user->id]);
});

test('that_user_can_be_restored', function () {
    $user = User::create([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password',
    ]);
    $user->delete();
    $this->assertSoftDeleted($user);
    $user->restore();
    $this->assertNotSoftDeleted($user);
    $this->assertDatabaseHas('users', ['id' => $user->id]);
});

test('that_user_can_be_force_deleted', function () {
    $user = User::create([
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password',
    ]);
    $user->delete();
    $this->assertSoftDeleted($user);
    $user->forceDelete();
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

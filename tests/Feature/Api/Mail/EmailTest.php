<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomMailable;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);


test('that_email_sent_when_user_register', function () {


    Mail::fake();
    $userData = [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    $respone = $this->post('/register', $userData);
    $respone->assertStatus(201);
    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'johndoe@example.com',
    ]);

    Mail::assertSent(WelcomMailable::class, function ($mail) use ($userData) {
        return $mail->hasTo($userData['email']);
    });
});

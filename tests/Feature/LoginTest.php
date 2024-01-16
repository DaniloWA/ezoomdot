<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Logins a user successfully', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $user = User::where('uuid', $user->uuid)->first();

    $response = $this->postJson('api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect($user)->not->toBeNull();
    expect($user)->toBeInstanceOf(User::class);
    $response->assertStatus(200);
});

test('Logins a user with wrong password', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('api/v1/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password_wrong',
    ]);

    $response->assertStatus(401);
});

test('Logins a user with wrong email', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('api/v1/auth/login', [
        'email' => 'wrong_email@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(401);
});

test('Logins a user that does not exist', function () {
    $response = $this->postJson('api/v1/auth/login', [
        'email' => 'not_existing_user@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(401);
});

test('Logins a user without an email and password', function () {
    $response = $this->postJson('api/v1/auth/login', [
        'email' => '',
        'password' => '',
    ]);

    $response->assertStatus(422);
});

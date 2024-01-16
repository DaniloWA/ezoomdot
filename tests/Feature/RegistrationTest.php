<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registers a user successfully', function () {
    $response = $this->postJson('api/v1/auth/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ]);

    $response->assertStatus(201);
    expect(User::where('email', 'test@example.com')->exists())->toBeTrue();
});

test('registers a user with an existing email', function () {
    User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    $response = $this->postJson('api/v1/auth/register', [
        'name' => 'Existing User',
        'email' => 'existing@example.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ]);

    $response->assertStatus(422);
});

test('registers a user with an invalid email', function () {
    $response = $this->postJson('api/v1/auth/register', [
        'name' => 'Test User',
        'email' => 'invalid_email',
        'password' => 'password',
        'password_confirmation' => 'password'
    ]);

    $response->assertStatus(422);
});

test('registers a user without a name', function () {
    $response = $this->postJson('api/v1/auth/register', [
        'name' => '',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ]);

    $response->assertStatus(422);
});

test('registers a user without a password', function () {
    $response = $this->postJson('api/v1/auth/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => '',
        'password_confirmation' => 'password'
    ]);

    $response->assertStatus(422);
});

test('registers a user with a mismatched password', function () {
    $response = $this->postJson('api/v1/auth/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'not_the_same_password'
    ]);

    $response->assertStatus(422);
});

test('registers a user with a name that is too long', function () {
    $name = str_repeat('long_name', 255);

    $response = $this->postJson('api/v1/auth/register', [
        'name' => $name,
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ]);

    $response->assertStatus(422);
});

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;

uses(RefreshDatabase::class);

test('logout a user successfully', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $token = $user->createToken('default_token');

    $response = $this->actingAs($user)
        ->withHeaders(['Authorization' => 'Bearer ' . $token->plainTextToken])
        ->postJson('api/v1/auth/logout');

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Tokens Revoked',
    ]);

    $this->assertNull(PersonalAccessToken::findToken($token->plainTextToken));
});

test('logout a user that does not exist', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $token = "fake_token";

    $response = $this->actingAs($user)
        ->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->postJson('api/v1/auth/logout');


    $this->assertNull(PersonalAccessToken::findToken($token));
    $response->assertStatus(401);
});

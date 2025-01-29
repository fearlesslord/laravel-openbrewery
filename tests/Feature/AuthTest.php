<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('authenticates a user and returns a token', function () {
    // 1) Arrange: creiamo un utente "root" in DB
    User::factory()->create([
        'user' => 'root',
        'password' => Hash::make('password'),
    ]);

    // 2) Act: chiamiamo l'endpoint /api/login
    $response = $this->postJson('/api/login', [
        'user'     => 'root',
        'password' => 'password',
    ]);

    // 3) Assert: ci aspettiamo status 200 e un campo 'token'
    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'data' => [
                'token'
            ]
        ]);
});

it('returns 401 on invalid credentials', function () {
    // Nessun utente esistente
    $response = $this->postJson('/api/login', [
        'user'     => 'nonexistent',
        'password' => 'wrong',
    ]);

    $response->assertStatus(401)
        ->assertJson(['message' => 'Credenziali non valide']);
});

it('returns 422 when validation fails', function () {
    $response = $this->postJson('/api/login', [
        // 'user' mancante
        'password' => 'password'
    ]);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => ['user'] // "user" dovrebbe essere required
        ]);
});

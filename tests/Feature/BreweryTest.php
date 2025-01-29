<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('requires authentication to access /api/breweries', function () {
    $response = $this->getJson('/api/breweries');
    $response->assertStatus(401);
});

it('returns brewery list for authenticated user', function () {
    $user = User::factory()->create([
        'user' => 'root',
        'password' => Hash::make('password'),
    ]);
    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->getJson('/api/breweries', [
        'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(200);

    $response->assertJsonStructure([
        "message",
        "data"=> [
            "*" => [
                "id",
                "name",
                "brewery_type",
                "address_1",
                "address_2",
                "address_3",
                "city",
                "state",
                "state_province",
                "postal_code",
                "country",
                "street",
                "longitude",
                "latitude",
                "phone",
                "website_url"
           ]
        ]
    ]);
});

it('returns 422 when validation fails in breweries endpoint', function () {
    $user = User::factory()->create([
        'user' => 'root',
        'password' => Hash::make('password'),
    ]);
    $token = $user->createToken('api-token')->plainTextToken;

    $response = $this->getJson('/api/breweries?page=1&per_page=9999', [
        'Authorization' => "Bearer $token"
    ]);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => ['per_page']
        ]);
});


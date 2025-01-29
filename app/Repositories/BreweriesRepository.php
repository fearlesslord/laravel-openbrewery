<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BreweriesRepositoryInterface;
use Illuminate\Support\Facades\Http;

class BreweriesRepository implements BreweriesRepositoryInterface
{
    protected string $breweriesUrl;
    public function __construct(string $breweriesUrl = null)
    {
        $this->breweriesUrl = $breweriesUrl ?: config('services.breweries.url');
    }
    public function fetchBreweries(int $page, int $perPage): array
    {
        $response = Http::get($this->breweriesUrl, [
            'page' => $page,
            'per_page' => $perPage,
        ]);

        if ($response->failed()) {
            return [];
        }

        return $response->json();
    }
}

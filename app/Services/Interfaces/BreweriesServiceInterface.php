<?php

namespace App\Services\Interfaces;

interface BreweriesServiceInterface
{
    public function getBreweries(int $page, int $perPage): array;
}


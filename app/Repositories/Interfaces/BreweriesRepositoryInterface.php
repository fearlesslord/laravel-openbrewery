<?php

namespace App\Repositories\Interfaces;

interface BreweriesRepositoryInterface
{
    public function fetchBreweries(int $page, int $perPage): array;
}

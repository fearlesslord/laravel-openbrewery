<?php

namespace App\Services;

use App\Services\Interfaces\BreweriesServiceInterface;
use App\Repositories\Interfaces\BreweriesRepositoryInterface;

class BreweriesService implements BreweriesServiceInterface
{
    protected BreweriesRepositoryInterface $breweriesRepo;

    public function __construct(BreweriesRepositoryInterface $breweriesRepo)
    {
        $this->breweriesRepo = $breweriesRepo;
    }

    public function getBreweries(int $page, int $perPage): array
    {
        return $this->breweriesRepo->fetchBreweries($page, $perPage);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\BreweriesRequest;
use App\Http\Resources\BreweryResource;
use App\Services\Interfaces\BreweriesServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class BreweryController extends Controller
{
    use ApiResponseTrait;
    private BreweriesServiceInterface $breweriesService;

    public function __construct(BreweriesServiceInterface $breweriesService)
    {
        $this->breweriesService = $breweriesService;
    }

    public function index(BreweriesRequest $request): JsonResponse
    {
        try {
            $requestData = $request->validated();

            $page = $requestData['page'] ?? 1;
            $perPage = $requestData['per_page'] ?? 10;

            $breweries = $this->breweriesService->getBreweries($page, $perPage);
            $resourceCollection = BreweryResource::collection($breweries);

            return $this->successResponse(
                'Birrerie recuperate con successo',
                $resourceCollection
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Si è verificato un errore durante il recupero delle birrerie',
                ['exception' => $e->getMessage()],
                500
            );
        }
    }
}

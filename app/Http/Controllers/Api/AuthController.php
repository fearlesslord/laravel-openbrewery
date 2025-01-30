<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = User::where('user', $data['user'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                return $this->errorResponse(
                    'Credenziali non valide',
                    [],
                    401
                );
            }

            $tokenName = 'api-token';
            $token = $user->createToken($tokenName)->plainTextToken;

            return $this->successResponse(
                'Login effettuato con successo',
                ['token' => $token]
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Si è verificato un errore durante il login',
                ['exception' => $e->getMessage()],
                500
            );
        }
    }
}

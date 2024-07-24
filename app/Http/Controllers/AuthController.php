<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:255'
        ]);

        $data = $this->authService->register($credentials);

        return Response::json($data, 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $data = $this->authService->login($credentials);

        if (!$data) {
            return Response::json(['message' => 'Bad creds'], 401);
        }

        return Response::json($data, 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return Response::json('Logged out', 201);
    }
}

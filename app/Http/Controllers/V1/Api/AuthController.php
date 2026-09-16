<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService){}

    public function register(RegisterRequest $request)
    {
        return $this->respond($this->authService->register($request->validated()));
    }

    public function login(LoginRequest $request)
    {
        return $this->respond($this->authService->authenticate(
            $request->validated('email'),
            $request->validated('password'),
        ));
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Logout efetuado com sucesso.']);
    }

    public function me(Request $request)
    {
        if (! $request->user()) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }

        return response()->json([
            'message' => 'Usuário autenticado.',
            'user' => new UserResource($request->user()),
        ]);
    }

    /**
     * Traduz o array padronizado do AuthService ($result) numa resposta HTTP,
     * usada por register() e login() — os dois únicos métodos que devolvem esse formato.
     */
    private function respond(array $result)
    {
        $payload = ['message' => $result['message']];

        if ($result['success']) {
            $payload['user'] = $result['user'];

            if ($result['token']) {
                $payload['token'] = $result['token'];
            }
        }

        return response()->json($payload, $result['status']);
    }
}

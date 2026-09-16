<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * Sign up: cria um novo utilizador (Recepcionista ou Administrador).
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'Utilizador criado com sucesso.',
            'user' => $user,
        ], 201);
    }

    /**
     * Login: recebe email e senha, devolve token de acesso (Sanctum).
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authService->authenticate(
            $request->validated('email'),
            $request->validated('password'),
        );

        if (! $result['success']) {
            return response()->json(['message' => $result['message']], $result['status']);
        }

        return response()->json([
            'message' => $result['message'],
            'user' => [
                'id'    => $result['user']->id,
                'name'  => $result['user']->name,
                'email' => $result['user']->email,
                'role'  => $result['user']->role,
            ],
            'token' => $result['token'],
        ]);
    }

    /**
     * Logout: revoga o token atual.
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Logout efetuado com sucesso.']);
    }

    /**
     * Me: retorna os dados do utilizador autenticado.
     */
    public function me(Request $request)
    {
        if(! $request->user()) {
            return response()->json(['message' => 'Não autenticado.'], 401);
        }
        
        return response()->json($request->user());
    }
}


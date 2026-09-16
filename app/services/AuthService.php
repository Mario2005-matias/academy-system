<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => $data['role'],
            'is_active' => true,
        ]);

        return $this->result(true, 201, 'Utilizador criado com sucesso.', $user);
    }

    public function authenticate(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return $this->result(false, 401, 'Credenciais inválidas.');
        }

        if (! $user->is_active) {
            return $this->result(false, 403, 'Utilizador inativo. Contacte o administrador.');
        }

        $token = $user->createToken('auth_token_' . now()->timestamp)->plainTextToken;

        return $this->result(true, 200, 'Login efetuado com sucesso.', $user, $token);
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    /**
     * Monta a resposta padronizada usada por todos os métodos do service:
     * ['success' => bool, 'status' => int, 'message' => string, 'user' => ?User, 'token' => ?string]
     */
    private function result(bool $success, int $status, string $message, ?User $user = null, ?string $token = null): array
    {
        return [
            'success' => $success,
            'status'  => $status,
            'message' => $message,
            'user'    => $user,
            'token'   => $token,
        ];
    }
}

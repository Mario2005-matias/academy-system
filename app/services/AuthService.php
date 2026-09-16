<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function authenticate(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return [
                'success' => false,
                'status'  => 401,
                'message' => 'Credenciais inválidas.',
                'user'    => null,
                'token'   => null,
            ];
        }

        if (! $user->is_active) {
            return [
                'success' => false,
                'status'  => 403,
                'message' => 'Utilizador inativo. Contacte o administrador.',
                'user'    => null,
                'token'   => null,
            ];
        }

        $token = $user->createToken('auth_token_' . now()->timestamp)->plainTextToken;

        return [
            'success' => true,
            'status'  => 200,
            'message' => 'Login efetuado com sucesso.',
            'user'    => $user,
            'token'   => $token,
        ];
    }

    /**
     * Revoga o token atualmente em uso.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    /**
     * Cria um novo utilizador (aplica regra: senha sempre com hash).
     */
    public function createUser(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);
    }
}

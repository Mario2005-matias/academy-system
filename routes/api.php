<?php

use App\Http\Controllers\V1\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::middleware('role:administrador,recepcionista')->group(function () {
        // Route::apiResource('alunos', AlunoController::class);
        // Route::post('/matriculas', [MatriculaController::class, 'store']);
        // Route::post('/pagamentos', [PagamentoController::class, 'store']);
        // Route::post('/checkins', [CheckinController::class, 'store']);
    });

    // Apenas Administrador pode:
    Route::middleware('role:administrador')->group(function () {
        // Route::apiResource('planos', PlanoController::class)->except(['index', 'show']);
        // Route::delete('/pagamentos/{id}', [PagamentoController::class, 'destroy']);
        // Route::apiResource('professores', ProfessorController::class);
        // Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});

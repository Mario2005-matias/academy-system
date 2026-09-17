<?php

use App\Http\Controllers\V1\Api\AuthController;
use App\Http\Controllers\V1\Api\CheckInController;
use App\Http\Controllers\V1\Api\EnrollementController;
use App\Http\Controllers\V1\Api\PaymentController;
use App\Http\Controllers\V1\Api\PlanController;
use App\Http\Controllers\V1\Api\ReportController;
use App\Http\Controllers\V1\Api\StudentController;
use App\Http\Controllers\V1\Api\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'me']);

    Route::middleware('role:administrador,recepcionista')->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::post('/enrollments', [EnrollementController::class, 'store'])->name('enrollments.store');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::post('/checkins', [CheckInController::class, 'store'])->name('checkins.store');
    });

    Route::middleware('role:administrador')->group(function () {
        Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
        Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);
        Route::apiResource('teachers', TeacherController::class);
        Route::get('/reports', [ReportController::class, 'index']);
    });
});

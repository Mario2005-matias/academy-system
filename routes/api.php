<?php

use App\Http\Controllers\V1\Api\AuthController;
use App\Http\Controllers\V1\Api\CheckInController;
use App\Http\Controllers\V1\Api\EnrollementController;
use App\Http\Controllers\V1\Api\PaymentController;
use App\Http\Controllers\V1\Api\PlanController;
use App\Http\Controllers\V1\Api\ReportController;
use App\Http\Controllers\V1\Api\StudentController;
use App\Http\Controllers\V1\Api\TeacherController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'me']);

    Route::middleware('role:admin,recepcionista')->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

        Route::apiResource('/enrollments', EnrollementController::class);

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

        Route::post('/checkins', [CheckInController::class, 'store'])->name('checkins.store');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/{plan}', [PlanController::class, 'show'])->name('plans.show');
        Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
        Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
        Route::patch('/plans/{plan}/status', [PlanController::class, 'updateStatus'])->name('plans.update.status');
        Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');


        Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
        Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');
        Route::apiResource('teachers', TeacherController::class);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

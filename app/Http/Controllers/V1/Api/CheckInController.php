<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckIn\StoreCheckInRequest;
use App\Http\Resources\CheckInResource;
use App\Models\Student;
use App\Services\CheckInService;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function __construct(protected CheckInService $checkInService) {}

    public function index(Student $student)
    {
        return CheckInResource::collection(
            $student->checkIns()->latest('check_in_date')->get()
        );
    }

    public function store(StoreCheckInRequest $request)
    {
        $checkIn = $this->checkInService->create($request->validated()['student_id']);

        return response()->json([
            'message' => 'Check-in registered successfully',
            'data'    => new CheckInResource($checkIn),
        ], 201);
    }

    public function attendance(Request $request, Student $student)
    {
        $days = $this->checkInService->countPresentDays(
            $student,
            $request->query('start_date'),
            $request->query('end_date'),
        );

        return response()->json([
            'student_id'   => $student->id,
            'days_present' => $days,
        ]);
    }
}

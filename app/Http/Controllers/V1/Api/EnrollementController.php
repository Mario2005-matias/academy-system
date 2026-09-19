<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollements\StoreEnrollmentRequest;
use App\Http\Requests\Enrollements\UpdateEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Enrollment;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;

class EnrollementController extends Controller
{
    public function __construct(protected EnrollmentService $enrollmentService) {}

    public function index()
    {
        return EnrollmentResource::collection(
            $this->enrollmentService->paginate()
        );
    }

    public function store(StoreEnrollmentRequest $request)
    {
        $enrollment = $this->enrollmentService->create($request->validated());

        return response()->json([
            'message' => 'Enrollment created successfully',
            'data'    => new EnrollmentResource($enrollment),
        ], 201);
    }

    public function show(Enrollment $enrollment)
    {
        return new EnrollmentResource($enrollment->load(['student', 'plan']));
    }

    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        $enrollment = $this->enrollmentService->update($enrollment, $request->validated());

        return response()->json([
            'message' => 'Enrollment updated successfully',
            'data'    => new EnrollmentResource($enrollment),
        ]);
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json(['message' => 'Enrollment deleted successfully']);
    }
}

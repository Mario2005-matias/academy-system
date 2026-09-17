<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\students\StoreRequest;
use App\Http\Requests\students\UpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::where('is_active', true)->get();
        return response()->json([
            'message' => 'Students retrieved successfully',
            'data' => StudentResource::collection($students),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        $student = Student::create($validatedData);

        return response()->json([
            'message' => 'Student created successfully',
            'data' => new StudentResource($student),
        ], 201);
    }

    public function show(Student $student)
    {
        return response()->json([
            'message' => 'Student retrieved successfully',
            'data' => new StudentResource($student),
        ]);
    }

    public function update(UpdateRequest $request, Student $student)
    {
        $student->update($request->validated());
        return response()->json([
            'message' => 'Student updated successfully',
            'data' => new StudentResource($student),
        ]);
    }

    public function destroy(Student $student)
    {
        if(!$student) {
            return response()->json([
                'message' => 'Student not found',
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully',
        ]);
    }
}

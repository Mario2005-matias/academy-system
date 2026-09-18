<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Plans\StoreRequest;
use App\Http\Requests\Plans\UpdatePlanStatusRequest;
use App\Http\Requests\Plans\UpdateRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $plan = Plan::create($request->validated());

        return response()->json([
            'message' => 'Plan created successfully',
            'data' => new PlanResource($plan),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        return response()->json([
            'message' => 'Plan retrieved successfully',
            'data' => new PlanResource($plan),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Plan $plan)
    {
        $plan->update($request->validated());

        return response()->json([
            'message' => 'Plan updated successfully',
            'data' => new PlanResource($plan),
        ]);
    }

    public function updateStatus(UpdatePlanStatusRequest $request, Plan $plan)
    {
        $plan->is_active = $request->boolean('is_active');
        $plan->save();

        return response()->json([
            'message' => $plan->is_active ? 'Plan activated successfully' : 'Plan deactivated successfully',
            'data' => new PlanResource($plan),
        ]);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->json([
            'message' => 'Plan deleted successfully',
        ]);
    }
}

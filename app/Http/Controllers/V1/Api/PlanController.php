<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use App\Http\Requests\Plans\StoreRequest;
use App\Http\Requests\Plans\UpdatePlanStatusRequest;
use App\Http\Requests\Plans\UpdateRequest;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
>>>>>>> feat/plans

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
<<<<<<< HEAD
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
=======
        $plans = Plan::where('is_active', true)->get();

        return response()->json([
            'message' => 'Plans retrieved successfully',
            'data' => PlanResource::collection($plans),
        ]);
>>>>>>> feat/plans
    }

    /**
     * Store a newly created resource in storage.
     */
<<<<<<< HEAD
    public function store(Request $request)
    {
        //
=======
    public function store(StoreRequest $request)
    {
        $plan = Plan::create($request->validated());

        return response()->json([
            'message' => 'Plan created successfully',
            'data' => new PlanResource($plan),
        ], 201);
>>>>>>> feat/plans
    }

    /**
     * Display the specified resource.
     */
<<<<<<< HEAD
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
=======
    public function show(Plan $plan)
    {
        return response()->json([
            'message' => 'Plan retrieved successfully',
            'data' => new PlanResource($plan),
        ]);
>>>>>>> feat/plans
    }

    /**
     * Update the specified resource in storage.
     */
<<<<<<< HEAD
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
=======
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
            'message' => $plan->is_active ? 'Plan activated successfully' : 'Plan desactivated successfully',
            'data' => new PlanResource($plan),
        ]);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->json([
            'message' => 'Plan deleted successfully',
        ]);
>>>>>>> feat/plans
    }
}

<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\StorePaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function index(Enrollment $enrollment)
    {
        return PaymentResource::collection(
            $enrollment->payments()->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        dd($request);
        $payment = $this->paymentService->create($request->validated());


        return response()->json([
            'message' => 'Pagamento criado com sucesso.',
            'data' => new PaymentResource($payment),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
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
    }

    /**
     * Update the specified resource in storage.
     */
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
    }
}

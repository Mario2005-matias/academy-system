<?php

namespace App\Http\Controllers\V1\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\StorePaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function index(Enrollment $enrollment)
    {
        $payments = Payment::paginate(15);

        return response()->json([
            'message' => '',
            'data' => PaymentResource::collection($payments)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = $this->paymentService->create($request->validated());

        return response()->json([
            'message' => 'Pagamento criado com sucesso.',
            'data' => new PaymentResource($payment),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return response()->json([
            'message' => 'Pagamento encontrado com sucesso',
            'data' => new PaymentResource($payment)
        ]);
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
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json([
            'message' => 'Pagamaneto eliminado com sucesso',
        ], 200);
    }
}

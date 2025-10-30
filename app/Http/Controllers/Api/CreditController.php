<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index() {
        $credits = Credit::all();
        return apiResponse([
            'status' => 'success',
            'message' => 'Lista de créditos',
            'data' => $credits,
        ]);
    }

    public function show($id) {
        $credit = Credit::find($id);
        if (! $credit) {
            return apiResponse([
                'status' => 'error',
                'message' => 'Crédito no encontrado',
                'data' => null,
                'error' => 'Crédito con ID ' . $id . ' no existe',
            ], 404);
        }
        return apiResponse([
            'status' => 'success',
            'message' => 'Detalle del crédito',
            'data' => $credit,
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'product_id' => 'required|exists:financial_products,id',
            'client_id' => 'required|exists:clients,id',
            'approved_by' => 'required|exists:users,id'
        ]);

        $finacialProduct = FinancialProduct::findOrFail($request->product_id);
        if (!$finacialProduct) {
            throw new Exception('Producto financiero no encontrado');
        }
        $validatedData['interest_rate'] = $finacialProduct->interest_rate;
        $validatedData['term_months'] = $finacialProduct->max_term_months;
        $validatedData['start_date'] = now();
        $validatedData['end_date'] = now()->addMonths($finacialProduct->max_term_months);


        $credit = Credit::create($validatedData);

        // CREAR PAGOS AUTOMATICOS SEGUN EL PRODUCTO FINANCIERO
        for ($i = 1; $i <= $credit->term_months; $i++) {
            $payment = [
                'amount' => $credit->amount / $credit->term_months,
                'payment_type' => null,
                'payment_note' => null,
                'status' => 'no pagado',
                'extra_payment' => 0,
                'total' => $credit->amount / $credit->term_months,
                'start_date' => now(),
                'due_date' => now()->addMonths($i),
                'paid_date' => null,
                'credit_id' => $credit->id,
                'processed_id' => null,
            ];
            Payment::create($payment);
        }

        return apiResponse([
            'status' => 'success',
            'message' => 'Crédito creado correctamente',
            'data' => $credit,
            'error' => null,
        ], 200);
    }

    public function changeStatus(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:credits,id',
            'status' => 'required|in:active,inactive',
        ]);
        $credit = Credit::find($validatedData['id']);
        $credit->status = $validatedData['status'];
        $credit->save();

        return apiResponse([
            'status' => 'success',
            'message' => 'Estado del crédito actualizado correctamente',
            'data' => $credit,
            'error' => null,
        ], 200);
    }

    public function calcPaidBalance(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:credits,id',
        ]);
        $payments = Payment::where('credit_id', $validatedData['id'])->get();
        
        //Sumar todos los pagos que su estado es "pagado realizado" y ponerlo en creditos
        $total = 0;
        foreach ($payments as $payment) {
            if ($payment->status === 'pagado realizado') {
                $total += $payment->amount;
            }
        }

        $credit = Credit::find($validatedData['id'])->update(['paid_balance' => $total]);
        

        return apiResponse([
            'status' => 'success',
            'message' => 'Balance pagado calculado correctamente',
            'data' => [
                'credito' => $credit,
                'total_pagado' => $total,
            ],
            'error' => null,
        ], 200);
    }

}

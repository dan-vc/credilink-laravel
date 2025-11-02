<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\Payment;
use App\Models\Report;
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
        $validatedData['term_months'] = $finacialProduct->max_term_months; // Meses del crédito
        $validatedData['start_date'] = now(); // Obtiene la fecha actual
        $validatedData['end_date'] = now()->addMonths($finacialProduct->max_term_months); // Ahora + X Meses


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

        Report::create([
            'report_date'      => now(),
            'total_paid'       => 0,
            'pending_balance'  => $credit->amount,
            'months_paid'      => 0,
            'months_pending'   => $credit->term_months,
            'interest_accrued' => 0,
            'credit_id'        => $credit->id,
            'client_id'        => $credit->client_id,
        ]);

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
            'status' => 'required|in:approved,rejected,pending,paid',
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

        // Obtener el crédito
        $credit = Credit::findOrFail($validatedData['id']);

        // Obtener todos los pagos del crédito
        $payments = Payment::where('credit_id', $credit->id)->get();

        // Calcular totales
        $totalPaid = $payments
            ->where('status', 'pagado realizado')
            ->sum('amount');

        $pendingBalance = $credit->amount - $totalPaid;

        // Calcular meses pagados y pendientes
        $monthsPaid = $payments->where('status', 'pago realizado')->count();
        $monthsPending = $credit->term_months - $monthsPaid;

        // Calcular interés acumulado (si aplica)
        $interestAccrued = $payments
            ->where('status', 'atrasado')
            ->sum('extra_payment');

        // Actualizar crédito
        $credit->update([
            'paid_balance' => $totalPaid,
            'pending_balance' => $pendingBalance,
        ]);

        // Buscar o crear reporte
        $report = Report::firstOrNew(['credit_id' => $credit->id]);
        $report->fill([
            'report_date' => now(),
            'total_paid' => $totalPaid,
            'pending_balance' => $pendingBalance,
            'months_paid' => $monthsPaid,
            'months_pending' => $monthsPending,
            'interest_accured' => $interestAccrued,
            'client_id' => $credit->client_id,
        ]);
        $report->save();

        return apiResponse([
            'status' => 'success',
            'message' => 'Balance y reporte actualizados correctamente',
            'data' => [
                'credito' => $credit->fresh(),
                'reporte' => $report,
                'total_pagado' => $totalPaid,
                'saldo_pendiente' => $pendingBalance,
                'meses_pagados' => $monthsPaid,
                'meses_pendientes' => $monthsPending,
                'interes_acumulado' => $interestAccrued,
            ],
            'error' => null,
        ], 200);
    }

}

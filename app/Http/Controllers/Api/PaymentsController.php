<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Credit;
use App\Models\Payment;
use App\Models\Report;
use Exception;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    //Mostrar todos los pagos de todos los créditos
    public function index() {
        $payments = Payment::all();
        return apiResponse([
            'status' => 'success',
            'message' => 'Lista de pagos de todos los créditos',
            'data' => $payments,
        ]);
    }

    //Mostrar detalle de un pago
    public function show($id) {
        $payment = Payment::find($id);
        if (! $payment) {
            return apiResponse([
                'status' => 'error',
                'message' => 'Pago no encontrado',
                'data' => null,
                'error' => 'Pago con ID ' . $id . ' no existe',
            ], 404);
        }
        return apiResponse([
            'status' => 'success',
            'message' => 'Detalle del pago',
            'data' => $payment,
        ]);
    }

    //Mostrar pagos de un crédito específico
    public function showsPaysCredit($id) {
        $payment = Payment::where('credit_id', $id)->get();
        if ($payment->isEmpty()) {
            return apiResponse([
                'status' => 'error',
                'message' => 'Pagos no encontrados para el crédito especificado',
                'data' => null,
                'error' => 'No existen pagos para el crédito con ID ' . $id,
            ], 404);
        }
        return apiResponse([
            'status' => 'success',
            'message' => 'Pagos del crédito',
            'data' => $payment,
        ]);
    }

    public function payPayment(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:payments,id',
            'payment_type' => 'required|in:efectivo,transferencia,tarjeta',
            'payment_note' => 'sometimes|string',
            'processed_by' => 'required|exists:users,id'
        ]);

        $payment = Payment::find($validatedData['id']);

        if($payment->status === 'pago realizado') {
            throw new Exception('El pago ya ha sido realizado');
        }
        if($payment->due_date < now()->toDateString() || $payment->status === 'atrasado') {
            $validatedData['extra_payment'] = round(($payment->credit->amount / $payment->credit->term_months) * ($payment->credit->interest_rate / 100),2);
            $validatedData['total'] = $payment->amount + $validatedData['extra_payment'];
        }
        $validatedData['status'] = 'pago realizado';
        $validatedData['paid_date'] = now()->toDateString();
        $payment->update($validatedData);
        //reporte
        $credit = $payment->credit;
        $payments = Payment::where('credit_id', $credit->id)->get();

        $totalPaid = $payments->where('status', 'pago realizado')->sum('amount');
        $pendingBalance = $credit->amount - $totalPaid;
        $monthsPaid = $payments->where('status', 'pago realizado')->count();
        $monthsPending = $credit->term_months - $monthsPaid;
        $interestAccrued = $payments->sum('extra_payment');

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
            'message' => 'Pago actualizado correctamente',
            'data' => $payment,
        ]);
    }

    public function changeStatus(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:payments,id',
            'status' => 'required|in:"pago realizado","no pagado","atrasado"',
        ]);

        $payment = Payment::find($validatedData['id']);
        $payment->update(['status' => $validatedData['status']]);
        return apiResponse([
            'status' => 'success',
            'message' => 'Estado del pago actualizado correctamente',
            'data' => $payment,
        ]);
    }


}

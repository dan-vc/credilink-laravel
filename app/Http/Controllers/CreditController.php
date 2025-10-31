<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Credit;
use App\Models\FinancialProduct;
use App\Models\Payment;
use App\Models\Report;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditController extends Controller
{
    public function index(Request $request)
    {
        // DB::enableQueryLog(); // 🔍 Activa el registro de consultass

        // $credits = Credit::all();

        // foreach ($credits as $credit) {
        //     $credit->client->name; // esto provoca N consultas extra
        //     $credit->approver->name; // esto provoca N consultas extra
        // }

        $query = $request->input('query');

        $clients = Client::all();
        $products = FinancialProduct::all();

        $credits = Credit::with(['client', 'approver', 'product'])->when($query, function ($q, $query) {
            $q->whereHas('client', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            })->orwhereHas('approver', function ($subQuery) use ($query) {
                $subQuery->where('name', 'like', "%$query%");
            });
        })->paginate(10);

        // dd(DB::getQueryLog()); // 🧾 Muestra todas las consultas ejecutadas

        return view('dashboard', compact('credits', 'clients', 'products'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'amount' => 'required|numeric|min:0',
                'term_months' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'product_id' => 'required|exists:financial_products,id',
                'client_id' => 'required|exists:clients,id',
            ]);

            $product = FinancialProduct::findOrFail($request->product_id);
            // $termMonths = Carbon::parse($request->start_date)->diffInMonths(Carbon::parse($request->end_date));
            $approvedBy = Auth::user()->id;

            $validatedData['interest_rate'] = $product->interest_rate;
            // $validatedData['term_months'] = $termMonths;
            $validatedData['approved_by'] = $approvedBy;

            $credit = Credit::create($validatedData);

            // CREAR PAGOS AUTOMATICOS SEGUN EL PRODUCTO FINANCIERO
            for ($i = 1; $i <= $credit->term_months; $i++) {
                $payment = [
                    'amount' => $credit->amount / $credit->term_months,
                    'payment_type' => null,
                    'payment_note' => null,
                    'status' => 'no pagado',
                    'extra_payment' => 0,
                    'total' => $credit->amount,
                    'start_date' => now(),
                    'due_date' => now()->addMonths($i),
                    'paid_date' => null,
                    'credit_id' => $credit->id,
                    'processed_by' => null,
                ];
                Payment::create($payment);
            }

            Report::create([
                'report_date' => now(),
                'total_paid' => 0,
                'pending_balance' => $credit->amount,
                'months_paid' => 0,
                'months_pending' => $credit->term_months,
                'interest_accrued' => 0,
                'credit_id' => $credit->id,
                'client_id' => $credit->client_id,
            ]);

            return redirect()->route('dashboard')->with('success', 'Credito generado exitosamente.');
        } catch (\Throwable $th) {
            dd($th);
        }

    }

    public function showCreditsByClient(Client $client)
    {
        $credits = $client->credits()->paginate(10);

        return view('credits', compact('credits', 'client'));
    }

    public function showPaymentsByCredit(Credit $credit)
    {
        $payments = $credit->payments()->paginate(10);

        return view('payments', compact('payments', 'credit'));
    }

    public function payPayment(Payment $payment) {
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

        $paymentsToShow = $credit->payments()->paginate(10);
        return view('payments', ['payments' => $paymentsToShow, 'credit' => $credit]);
    }
}

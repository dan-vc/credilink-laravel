<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Credit;
use App\Models\FinancialProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        $products = FinancialProduct::all();
        $credits = Credit::all();

        return view('dashboard', compact('credits', 'clients', 'products'));
    }

    public function store(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'amount' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'product_id' => 'required|exists:financial_products,id',
                'client_id' => 'required|exists:clients,id',
            ]);

            $product = FinancialProduct::findOrFail($request->product_id);
            $termMonths = Carbon::parse($request->start_date)->diffInMonths(Carbon::parse($request->end_date));
            $approvedBy = Auth::user()->id;

            $validatedData['interest_rate'] = $product->interest_rate;
            $validatedData['term_months'] = $termMonths;
            $validatedData['approved_by'] = $approvedBy;

            Credit::create($validatedData);

            return redirect()->route('dashboard')->with('success', 'Credito generado exitosamente.');
        } catch (\Throwable $th) {
            dd($th);
        }

    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinancialProduct;
use Illuminate\Http\Request;

class FinancialProductController extends Controller
{
    public function index() {
        $financial_product = FinancialProduct::all();
        return apiResponse([
            'status' => 'success',
            'message' => 'Lista de productos financieros',
            'data' => $financial_product,
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'sometimes|string',
            'interest_rate' => 'required|numeric',
            'max_term_months' => 'required|integer',
            'min_amount' => 'required|numeric',
            'max_amount' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);
        $financial_product = FinancialProduct::create($validatedData);
        return apiResponse([
            'status' => 'success',
            'message' => 'Producto financiero creado correctamente',
            'data' => $financial_product,
        ]);
    }

    public function update(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:financial_products,id',
            'name' => 'required|string',
            'description' => 'sometimes|string',
            'interest_rate' => 'required|numeric',
            'max_term_months' => 'required|integer',
            'min_amount' => 'required|numeric',
            'max_amount' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);
        $financial_product = FinancialProduct::find($validatedData['id']);
        $financial_product->update($validatedData);
        return apiResponse([
            'status' => 'success',
            'message' => 'Producto financiero actualizado correctamente',
            'data' => $financial_product,
        ]);
    }

    public function destroy(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:financial_products,id',
        ]);
        $financial_product = FinancialProduct::find($validatedData['id']);
        $financial_product->delete();
        return apiResponse([
            'status' => 'success',
            'message' => 'Producto financiero eliminado correctamente',
        ]);
    }
}

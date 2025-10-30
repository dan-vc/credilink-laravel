<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {
        $reports = Report::all();
        return apiResponse([
            'status' => 'success',
            'message' => 'Lista de reportes',
            'data' => $reports,
        ]);
    }

    public function show($id) {
        $report = Report::find($id);
        if (! $report) {
            return apiResponse([
                'status' => 'error',
                'message' => 'Reporte no encontrado',
                'data' => null,
                'error' => 'Reporte con ID ' . $id . ' no existe',
            ], 404);
        }
        return apiResponse([
            'status' => 'success',
            'message' => 'Detalle del reporte',
            'data' => $report,
        ]);
    }
    public function showReportByClient($clientId) {
        $report = Report::where('client_id', $clientId)->get();
        if (! $report) {
            return apiResponse([
                'status' => 'error',
                'message' => 'Reporte no encontrado para el cliente especificado',
                'data' => null,
                'error' => 'No existe reporte para el cliente con ID ' . $clientId,
            ], 404);
        }
        return apiResponse([
            'status' => 'success',
            'message' => 'Detalle del reporte del cliente',
            'data' => $report,
        ]);
    }

    public function showReportByCredit($creditId) {
        $report = Report::where('credit_id', $creditId)->get();
        if (! $report) {
            return apiResponse([
                'status' => 'error',
                'message' => 'Reporte no encontrado para el crédito especificado',
                'data' => null,
                'error' => 'No existe reporte para el crédito con ID ' . $creditId,
            ], 404);
        }
        return apiResponse([
            'status' => 'success',
            'message' => 'Detalle del reporte del crédito',
            'data' => $report,
        ]);
    }
}

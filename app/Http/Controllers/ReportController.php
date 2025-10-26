<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Credit;
use Carbon\Carbon;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $clients = Client::with(['credits', 'creator'])->paginate(10);

        // Obtener el mes y año actual
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;

        // Agrupar los créditos creados este mes por día
        $creditsPerDay = Credit::select(
            DB::raw('DAY(created_at) as day'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Crear arrays para Chart.js
        $labels = [];
        $data = [];

        // Generar un registro por cada día del mes
        $daysInMonth = $now->daysInMonth;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $labels[] = str_pad($day, 2, '0', STR_PAD_LEFT); // ejemplo: 01, 02, 03
            $found = $creditsPerDay->firstWhere('day', $day);
            $data[] = $found ? $found->total : 0;
        }

        // Crear la gráfica con Chartjs
        $chart = Chartjs::build()
            ->name('CreditsPerDayChart')
            ->type('bar')
            // ->size(['width' => "100%", 'height' => 300])
            ->options(['maintainAspectRatio' => false])
            ->labels($labels)
            ->datasets([
                [
                    'label' => 'Créditos otorgados',
                    'backgroundColor' => 'rgba(0, 112, 224, 0.5)',
                    'borderColor' => 'rgba(0, 112, 224, 0.7)',
                    'data' => $data,
                ],
            ]);

        return view('reports', compact('clients', 'chart'));
    }
}

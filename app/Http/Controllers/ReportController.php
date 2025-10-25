<?php

namespace App\Http\Controllers;

use App\Models\Client;

class ReportController extends Controller
{
    public function index()
    {
        $clients = Client::with(['credits', 'creator'])->paginate(10);

        return view('reports', compact('clients'));
    }
}

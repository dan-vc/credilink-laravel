<?php

namespace App\Http\Controllers;

use App\Models\Credit;

class CreditController extends Controller
{
    public function index()
    {
        $credits = Credit::all();

        return view('dashboard', compact('credits'));
    }
}

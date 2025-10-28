<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // $clients = Client::with('creator')->paginate(10);
        $clients = Client::with('creator')->when($query, function($q, $query){
            $q->where('name', 'like', "%$query%")->orwhereHas('creator', function($subQuery) use ($query){
                $subQuery->where('name', 'like', "%$query%");
            });
        })->paginate(10);

        return view('clients', compact('clients'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:empresa,cliente'
        ]);

        $validatedData['created_by'] = Auth::user()->id;

        Client::create($validatedData);

        return redirect()->route('clients')->with('success', 'Cliente creado exitosamente');
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:clients,id',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:empresa,cliente'
        ]);

        $user = Client::find($validatedData['id']);
        $user->update($validatedData);

        return redirect()->route('clients')->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:clients,id',
        ]);

        $user = Client::find($validatedData['id']);
        $user->delete();

        return redirect()->route('clients')->with('success', 'Cliente eliminado exitosamente');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index() {
        $clients = Client::all();
        return apiResponse([
            'status' => 'success',
            'message' => 'Lista de clientes',
            'data' => $clients,
        ]);
    }

    public function show($id) {
        $client = Client::find($id);
        if (! $client) {
            return apiResponse([
                'status' => 'error',
                'message' => 'Cliente no encontrado',
                'data' => null,
                'error' => 'Cliente con ID ' . $id . ' no existe',
            ], 404);
        }
        return apiResponse([
            'status' => 'success',
            'message' => 'Detalle del cliente',
            'data' => $client,
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:empresa,cliente',
            'created_by' => 'required|exists:users,id',
        ]);

        $client = Client::create($validatedData);

        return apiResponse([
            'status' => 'success',
            'message' => 'Cliente creado correctamente',
            'data' => $client,
            'error' => null,
        ], 200);
    }

    public function update(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:clients,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'status' => 'required|in:active,inactive',
            'type' => 'required|in:empresa,cliente',
        ]);

        $client = Client::find($validatedData['id']);
        $client->update($validatedData);

        return apiResponse([
            'status' => 'success',
            'message' => 'Cliente actualizado correctamente',
            'data' => $client,
            'error' => null,
        ], 200);
    }

    public function destroy(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:clients,id',
        ]);

        $client = Client::find($validatedData['id']);
        $client->delete();

        return apiResponse([
            'status' => 'success',
            'message' => 'Cliente eliminado correctamente',
            'error' => null,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return apiResponse([
            'status' => 'success',
            'message' => 'Lista de usuarios',
            'data' => $users,
        ]);
    }

    public function show($id) {
        $user = User::find($id);
        if (! $user) {
            return apiResponse([
                'status' => 'error',
                'message' => 'Usuario no encontrado',
                'data' => null,
                'error' => 'Usuario con ID ' . $id . ' no existe',
            ], 404);
        }
        return apiResponse([
            'status' => 'success',
            'message' => 'Detalle del usuario',
            'data' => $user,
        ]);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:roles,id',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        return apiResponse([
            'status' => 'success',
            'message' => 'Usuario creado correctamente',
            'data' => $user,
            'error' => null,
        ], 200);
    }

    public function update(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'sometimes',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:roles,id',
        ]);

        if (! empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']); // No cambiar la actual
        }

        $user = User::find($validatedData['id']);
        $user->update($validatedData);

        return apiResponse([
            'status' => 'success',
            'message' => 'Usuario actualizado correctamente',
            'data' => $user,
            'error' => null,
        ], 200);
    }

    public function destroy(Request $request) {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:users,id',
        ]);

        $user = User::find($validatedData['id']);
        $user->delete();

        return apiResponse([
            'status' => 'success',
            'message' => 'Usuario eliminado correctamente',
            'data' => null,
            'error' => null,
        ], 200);
    }
}

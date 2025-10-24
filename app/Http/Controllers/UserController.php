<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::with('role')->paginate(10);

        return view('users', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('users')->with('success', 'Empleado creado exitosamente');
    }

    public function update(Request $request)
    {
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

        return redirect()->route('users')->with('success', 'Empleado actualizado exitosamente');
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:users,id',
        ]);

        $user = User::find($validatedData['id']);
        $user->delete();

        return redirect()->route('users')->with('success', 'Empleado eliminado exitosamente');
    }
}

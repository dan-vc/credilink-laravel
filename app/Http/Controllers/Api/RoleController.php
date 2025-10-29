<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return apiResponse([
            'status' => 'success',
            'message' => 'Roles encontrados',
            'data' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'sometimes',
        ]);

        $role = Role::create($validatedData);
        return apiResponse([
            'status' => 'success',
            'message' => 'Rol creado correctamente',
            'data' => $role,
        ]);
    }
    
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:roles,id',
            'name' => 'required|string',
            'description' => 'sometimes',
        ]);
    
        $rol = Role::find($validatedData['id']);
        $rol->update($validatedData);

        return apiResponse([
            'status' => 'success',
            'message' => 'Rol actualizado exitosamente',
            'data' => $rol,
        ]);
    }
    
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:roles,id',
        ]);
    
        $rol = Role::find($validatedData['id']);
        $rol->delete();
        return apiResponse([
            'status' => 'success',
            'message' => 'Rol eliminado exitosamente',
            'data' => null,
        ]);
    }
}

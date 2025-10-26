<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $roles = Role::when($query, function($q, $query){
            $q->where('name', 'like', "%$query%");
        })->paginate(10);

        return view('roles', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'sometimes',
        ]);

        Role::create($validatedData);
        return redirect()->route('roles')->with('success', 'Rol creado exitosamente');
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
        return redirect()->route('roles')->with('success', 'Rol actualizado exitosamente');
    }
    
    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric|exists:roles,id',
        ]);
    
        $rol = Role::find($validatedData['id']);
        $rol->delete();
        return redirect()->route('roles')->with('success', 'Rol eliminado exitosamente');
    }
}

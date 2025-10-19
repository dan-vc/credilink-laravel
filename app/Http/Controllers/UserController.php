<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $users = User::with('role')->get();

        return view('users', compact('users', 'roles'));
    }
}

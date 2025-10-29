<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:roles,id',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
        return apiResponse([
            'status' => 'success',
            'message' => 'Usuario registrado correctamente',
            'data' => $data,
            'error' => null,
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw new HttpException(401, 'Correo o contraseña incorrecta.');
        }

        
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;
        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
        return apiResponse([
            'status' => 'success',
            'message' => 'Sesión iniciada correctamente.',
            'data' => $data,
            'error' => null,
        ], 200);

    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        
        return apiResponse([
            'status' => 'success',
            'message' => 'Sesión cerrada correctamente.',
            'data' => null,
            'error' => null,
        ]);
    }
}

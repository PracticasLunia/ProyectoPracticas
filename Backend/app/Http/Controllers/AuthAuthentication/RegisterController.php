<?php

namespace App\Http\Controllers\AuthAuthentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BienvenidoMail;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $datos = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($datos);

        $token = $user->createToken('api-token')->plainTextToken;

        Mail::to($user)->send(new BienvenidoMail($user));

        return response()->json([
            'user'    => $user,
            'token'   => $token,
            'message' => 'Cuenta creada correctamente',
        ], 201);
    }
}

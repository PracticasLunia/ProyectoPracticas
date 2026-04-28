<?php

namespace App\Http\Controllers\AuthAuthentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'No autenticado o token inválido'
            ], 401);
        }

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout correcto'
        ], 200);
    }
}

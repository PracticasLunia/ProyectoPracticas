<?php

namespace App\Http\Controllers\AuthAuthentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        //El middleware actua en estos casos, por lo que nunca se ejecutara
        // if (!$user) {
        //     return response()->json([
        //         'message' => 'No autenticado o token inválido'
        //     ], 401);
        // }

        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout correcto'
        ], 200);
    }
}

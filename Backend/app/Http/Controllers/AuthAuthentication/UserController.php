<?php

namespace App\Http\Controllers\AuthAuthentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'user' => null,
                'message' => 'Usuario no encontrado'
            ], 401);
        }

        return response()->json([
            'user' => $user,
            'message' => 'Usuario encontrado'
        ], 200);

    }
}

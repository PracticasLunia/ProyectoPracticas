<?php

namespace App\Http\Controllers\AuthAuthentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ){}

    public function __invoke(Request $request){

        //Validacion de existencia y credenciales del usuario
        $user = $this->userRepository->getByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'user' => null,
                'token' => null,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        //Respuesta con creacion de token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Sesion iniciada correctamente'
        ], 200);
    }
}

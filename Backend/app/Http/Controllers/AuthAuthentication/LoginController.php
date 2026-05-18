<?php

namespace App\Http\Controllers\AuthAuthentication;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Authentication\Login;
use App\Http\UseCases\Authentication\LoginRequest;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use Throwable;

class LoginController extends Controller
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly Login $login
    ){}

    public function __invoke(Request $request){

        try {

            $user = $this->login->handle( new LoginRequest(
                email: $request->input('email'),
                password: $request->input('password')
            ));

            //Respuesta con creacion de token
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Sesion iniciada correctamente'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'user' => null,
                'token' => null,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

    }
}

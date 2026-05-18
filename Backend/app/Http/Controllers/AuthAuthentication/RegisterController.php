<?php

namespace App\Http\Controllers\AuthAuthentication;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Authentication\Register;
use App\Http\UseCases\Authentication\RegisterRequest;
use App\Http\Validators\Authentication\RegisterValidator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function __construct(
        private readonly Register $register
    ){}

    public function __invoke(RegisterValidator $request){

        $user = $this->register->handle( new RegisterRequest(
            name: $request->input('name'),
            email: $request->input('email'),
            password: $request->input('password'),
        ));

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user'    => $user,
            'token'   => $token,
            'message' => 'Cuenta creada correctamente',
        ], 201);
    }
}

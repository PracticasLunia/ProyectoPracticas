<?php

namespace App\Http\Controllers\AuthAuthentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BienvenidoMail;
use App\Repositories\User\UserRepositoryInterface;

class RegisterController extends Controller
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ){}

    public function __invoke(Request $request){
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $this->userRepository->store($data);

        $token = $user->createToken('api-token')->plainTextToken;

        Mail::to($user)->send(new BienvenidoMail($user));

        return response()->json([
            'user'    => $user,
            'token'   => $token,
            'message' => 'Cuenta creada correctamente',
        ], 201);
    }
}

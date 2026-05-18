<?php

namespace App\Http\UseCases\Authentication;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\BienvenidoMail;

final readonly class Register {

    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function handle(RegisterRequest $request): User {

        $user = $this->userRepository->store([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        //$token = $user->createToken('api-token')->plainTextToken;

        Mail::to($user)->send(new BienvenidoMail($user));

        return $user;
    }

}

?>

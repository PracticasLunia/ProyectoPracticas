<?php

namespace App\Http\UseCases\Authentication;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Exception;

final readonly class Login {

    public function __construct(
        private UserRepositoryInterface $userRepository
    ){}

    public function handle(LoginRequest $request): ? User {

        //Validacion de existencia y credenciales del usuario
        $user = $this->userRepository->getByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return throw new Exception("Usuario inexistente o con credenciales invalidas");
        }

        return $user;
    }

}

?>

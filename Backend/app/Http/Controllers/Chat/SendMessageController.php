<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Chat\SendMessage;
use App\Http\UseCases\Chat\SendMessageRequest;
use App\Http\Validators\Chat\SendMessageValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SendMessageController extends Controller
{

    public function __construct(
        private readonly SendMessage $sendMessage
    ){}

    public function __invoke(SendMessageValidator $request)
    {
        try {

            $datos = $this->sendMessage->handle( new SendMessageRequest(
                message: $request->input('message'),
                model: config('services.azure_openai.model')
            ));

            return response()->json([
                'data'=>$datos,
                'message'=>'Peticion resuelta con exito',
                'errors'=>[]
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'Error al intentar actualizar el genero',
                'errors'=>$e->errors(),
            ], 422 );
        }

    }
}

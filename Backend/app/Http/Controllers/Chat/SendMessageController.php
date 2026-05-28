<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\UseCases\Chat\SendMessage;
use App\Http\UseCases\Chat\SendMessageRequest;
use App\Http\Validators\Chat\SendMessageValidator;
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
                messages: $request->input('messages'),
                model: config('services.azure_openai.model'),
                user:     $request->user(), 
            ));

            return response()->json([
                'data'=>$datos,
                'message'=>'Peticion resuelta con exito',
                'errors'=>[]
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'data'=>null,
                'message'=>'No se pudo enviar el mensaje',
                'errors'=>$e->errors(),
            ], 422 );
        }

    }
}

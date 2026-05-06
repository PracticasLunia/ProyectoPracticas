<?php

namespace Tests\Feature\Mail;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\BienvenidoMail;
use App\Models\User;

class ContenidoMailTest extends TestCase
{

    use RefreshDatabase;

    public function test_bienvenido_mail_full(): void {
        Mail::fake();

        $user = User::factory()->create();

        Mail::to($user->email)->send(new BienvenidoMail($user));

        Mail::assertSent(BienvenidoMail::class, function ($mail) use ($user) {
            return
                $mail->user->is($user) &&
                $mail->envelope()->subject === 'Bienvenido a Biblioteca' &&
                $mail->content()->markdown === 'mail.bienvenido' &&
                $mail->hasTo($user->email);
        });
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SecurityCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $user;

    // Recibimos los datos desde el controlador
    public function __construct($code, $user)
    {
        $this->code = $code;
        $this->user = $user;
    }

    // Preparamos el correo
    public function build()
    {
        // Actualizamos el asunto y usamos la vista personalizada
        return $this->subject('Tu Código de Acceso - Cine Screenbites')
                    ->view('emails.security_code')
                    // Incrustamos el logo blanco internamente con el ID "logo.png"
                    ->attachData(file_get_contents(public_path('img/img/Logo-Blanco.png')), 'logo.png', [
                        'as' => 'logo.png',
                        'mime' => 'image/png',
                        'display' => 'inline',
                        'content_id' => 'logo.png' // Este es el CID que usaremos en el HTML
                    ]);
    }
}
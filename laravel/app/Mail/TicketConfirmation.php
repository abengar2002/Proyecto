<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    // IMPORTANTE: Tiene que ser public para que Blade la reconozca
    public $orderData;

    public function __construct($orderData)
    {
        $this->orderData = $orderData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tus entradas de Screenbites',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AddUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clientId;
    public $clientEmail;
    public $token;

    public function __construct($clientId, $clientEmail, $token)
    {
        $this->clientId = $clientId;
        $this->clientEmail = $clientEmail;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Welcome to Trackify Media')
                    ->view('emails.user_password_mail');
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Generate User Password !',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

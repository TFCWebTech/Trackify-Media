<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendNewsMailsWithTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $client_id;
    public $client_ids_array;
    public $details;
    public $get_client_details;

    public function __construct($client_id, $client_ids_array, $details, $get_client_details)
    {
        $this->client_id = $client_id;
        $this->client_ids_array = $client_ids_array;
        $this->details = $details;
        $this->get_client_details = $get_client_details;
    }

    public function build()
    {
        return $this->view('emails.news_mail_with_template')
                    ->with([
                        'client_id' => $this->client_id,
                        'client_ids_array' => $this->client_ids_array,
                        'details' => $this->details,
                        'get_client_details' => $this->get_client_details
                    ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send News Mails With Template',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.news_mail_with_template',
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

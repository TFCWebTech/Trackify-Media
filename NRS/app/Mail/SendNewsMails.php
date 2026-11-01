<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendNewsMails extends Mailable
{
    use Queueable, SerializesModels;

    public $client_id;
    public $client_ids;
    public $get_news_data;

    /**
     * Create a new message instance.
     */
    public function __construct($client_id, $client_ids, $get_news_data)
    {
        $this->client_id = $client_id;
        $this->client_ids = $client_ids;
        $this->get_news_data = $get_news_data;
    }

    public function build()
    {
        return $this->view('emails.news_mail')
                    ->with([
                        'client_id' => $this->client_id,
                        'client_ids' => $this->client_ids,
                        'get_client_data' => $this->get_news_data['get_client_data'], // Make sure this matches
                        'get_news_details' => $this->get_news_data['get_news_details'],
                        'get_comp_data' => $this->get_news_data['get_comp_data'],
                        'get_industry_data' => $this->get_news_data['get_industry_data'],
                    ]);
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send News Mails',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.news_mail',
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

<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerQuoteAcknowledgment extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;

    public function __construct(QuoteRequest $quote)
    {
        $this->quote = $quote;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'We have received your quote request - Dignity Traders Ltd',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer_quote_acknowledgment',
        );
    }
}

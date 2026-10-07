<?php

namespace App\Mail;

use App\Models\QuoteRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteProposalEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $quote;
    public $pdfPath;
    public $pdfName;

    public function __construct(QuoteRequest $quote, $pdfPath, $pdfName)
    {
        $this->quote = $quote;
        $this->pdfPath = $pdfPath;
        $this->pdfName = $pdfName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Quotation Proposal - Dignity Traders Ltd',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.quote_proposal',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->pdfPath)->as($this->pdfName)->withMime('application/pdf'),
        ];
    }
}

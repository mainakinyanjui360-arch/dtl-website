<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryReplyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $replyMessage;
    public $filePath;
    public $fileName;

    public function __construct(Inquiry $inquiry, $replyMessage, $filePath = null, $fileName = null)
    {
        $this->inquiry = $inquiry;
        $this->replyMessage = $replyMessage;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: ' . $this->inquiry->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry_reply',
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        if ($this->filePath) {
            $attachments[] = Attachment::fromPath($this->filePath)->as($this->fileName);
        }
        return $attachments;
    }
}

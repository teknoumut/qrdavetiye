<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public ContactMessage $msg;

    public function __construct(ContactMessage $msg)
    {
        $this->msg = $msg;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Yeni İletişim Mesajı - '.$this->msg->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message',
        );
    }
}

<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Queue\InteractsWithQueue;

class PlanoTrabalhoAtribuido extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, MailableTrait;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $notifiable,
        public Collection $planosTrabalho,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SUAPNE - Novos planos de trabalho foram atribuidos a você',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.plano-trabalho.atribuido',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

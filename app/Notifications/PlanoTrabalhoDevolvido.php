<?php

namespace App\Notifications;

use App\Models\PlanoTrabalhoEstudante;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;
use App\Mail\PlanoTrabalhoDevolvido as PlanoTrabalhoDevolvidoMailable;

class PlanoTrabalhoDevolvido extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public PlanoTrabalhoEstudante $planoTrabalho,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): Mailable
    {
        return (new PlanoTrabalhoDevolvidoMailable($notifiable, $this->planoTrabalho))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

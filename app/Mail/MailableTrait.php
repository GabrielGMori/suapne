<?php

namespace App\Mail;
use Illuminate\Queue\Middleware\RateLimited;

trait MailableTrait
{
    public $tries = 20;
    public $backoff = 30;

    public function middleware(): array
    {
        return [new RateLimited('emails')];
    }
}

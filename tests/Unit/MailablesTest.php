<?php

use App\Mail\SolicitacaoRegistroAceita;
use App\Mail\SolicitacaoRegistroEnviada;
use App\Mail\SolicitacaoRegistroRecusada;
use App\Mail\VerificarEmail;
use App\Models\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Queue\Middleware\RateLimited;

test('SolicitacaoRegistroAceita mailable contains correct envelope and markdown', function () {
    $user = new User(['nome' => 'Ana Paula', 'email' => 'ana@teste.com']);
    $mailable = new SolicitacaoRegistroAceita($user);

    expect($mailable->envelope()->subject)->toBe('SUAPNE - Solicitação de registro aceita')
        ->and($mailable->content()->markdown)->toBe('mail.solicitacao-registro.aceita')
        ->and($mailable->newUser->nome)->toBe('Ana Paula');
});

test('SolicitacaoRegistroRecusada mailable contains correct envelope, name and optional observation', function () {
    $mailable = new SolicitacaoRegistroRecusada('Carlos Silva', 'Documento ilegível');

    expect($mailable->envelope()->subject)->toBe('SUAPNE - Solicitação de registro recusada')
        ->and($mailable->content()->markdown)->toBe('mail.solicitacao-registro.recusada')
        ->and($mailable->nome)->toBe('Carlos Silva')
        ->and($mailable->observacao)->toBe('Documento ilegível');
});

test('SolicitacaoRegistroEnviada mailable has correct subject and markdown', function () {
    $mailable = new SolicitacaoRegistroEnviada('Mariana Lima');

    expect($mailable->envelope()->subject)->toBe('SUAPNE - Solicitação de registro enviada com sucesso')
        ->and($mailable->content()->markdown)->toBe('mail.solicitacao-registro.enviada')
        ->and($mailable->nome)->toBe('Mariana Lima');
});

test('VerificarEmail mailable has verification code and subject', function () {
    $mailable = new VerificarEmail('Roberto Alves', '123456');

    expect($mailable->envelope()->subject)->toBe('SUAPNE - Confirme seu e-mail de cadastro')
        ->and($mailable->content()->markdown)->toBe('mail.solicitacao-registro.verificar-email')
        ->and($mailable->nome)->toBe('Roberto Alves')
        ->and($mailable->code)->toBe('123456');
});

test('queued mailables use the configured emails rate limiter', function () {
    $user = new User(['nome' => 'Ana Paula', 'email' => 'ana@teste.com']);
    $mailable = new SolicitacaoRegistroAceita($user);

    $middleware = $mailable->middleware();
    $rateLimiter = app(RateLimiter::class);
    $limit = $rateLimiter->limiter('emails')(new stdClass);
    $key = md5('emails');

    expect($middleware)->toHaveCount(1)
        ->and($middleware[0])->toBeInstanceOf(RateLimited::class)
        ->and($limit)->toBeObject()
        ->and($limit->maxAttempts)->toBe(5)
        ->and($limit->decaySeconds)->toBe(60);

    foreach (range(1, 5) as $attempt) {
        $rateLimiter->hit($key, 60);
    }

    expect($rateLimiter->tooManyAttempts($key, 5))->toBeTrue();

    $rateLimiter->resetAttempts($key);
});

test('queued mailable is not sent when the emails rate limit is reached', function () {
    $user = new User(['nome' => 'Ana Paula', 'email' => 'ana@teste.com']);
    $mailable = new SolicitacaoRegistroAceita($user);
    $rateLimiter = app(RateLimiter::class);
    $key = md5('emails');
    $job = new class {
        public int $releasedAfter = 0;
        public bool $nextCalled = false;

        public function release($delay = 0)
        {
            $this->releasedAfter = $delay;

            return true;
        }
    };

    foreach (range(1, 5) as $attempt) {
        $rateLimiter->hit($key, 60);
    }

    $middleware = $mailable->middleware()[0];
    $result = $middleware->handle($job, function ($job) {
        $job->nextCalled = true;

        return $job;
    });

    expect($result)->toBeTrue()
        ->and($job->releasedAfter)->toBeGreaterThan(0)
        ->and($job->nextCalled)->toBeFalse();

    $rateLimiter->resetAttempts($key);
});

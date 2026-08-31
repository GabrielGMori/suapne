<?php

use App\Mail\SolicitacaoRegistroAceita;
use App\Mail\SolicitacaoRegistroEnviada;
use App\Mail\SolicitacaoRegistroRecusada;
use App\Mail\VerificarEmail;
use App\Models\User;

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

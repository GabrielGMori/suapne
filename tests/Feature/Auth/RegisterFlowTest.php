<?php

use App\Enums\RoleEnum;
use App\Enums\StatusSolicitacaoRegistroEnum;
use App\Mail\SolicitacaoRegistroAceita;
use App\Mail\SolicitacaoRegistroEnviada;
use App\Mail\SolicitacaoRegistroRecusada;
use App\Mail\VerificarEmail;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\SolicitacaoRegistro;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

test('submitting registration initiates email verification flow', function () {
    Mail::fake();

    $curso = Curso::factory()->create();
    $disciplina = Disciplina::factory()->create(['curso_id' => $curso->id]);

    $payload = [
        'nome' => 'Professor Fulano',
        'email' => 'fulano@ifpr.edu.br',
        'password' => 'senhaSegura123',
        'password_confirmation' => 'senhaSegura123',
        'role' => RoleEnum::PROFESSOR_REGULAR->value,
        'campos' => [
            'disciplinas' => [$disciplina->id],
        ],
    ];

    $response = $this->post(route('cadastro.submit'), $payload);

    $response->assertRedirect(route('cadastro.verify.form'));
    $response->assertSessionHas('cadastro_email', 'fulano@ifpr.edu.br');

    Mail::assertQueued(VerificarEmail::class, function ($mail) {
        return $mail->hasTo('fulano@ifpr.edu.br') && strlen($mail->code) === 6;
    });

    $cached = Cache::get("cadastro_pendente:fulano@ifpr.edu.br");
    expect($cached)->not->toBeNull();
});

test('verifyForm redirects to login when session is missing', function () {
    $response = $this->get(route('cadastro.verify.form'));
    $response->assertRedirect(route('login'));
});

test('verify fails with invalid code and locks out after 5 attempts', function () {
    $email = 'tentativa@ifpr.edu.br';
    $code = '123456';

    Cache::put("cadastro_pendente:{$email}", Crypt::encrypt([
        'nome' => 'Tentativa Teste',
        'email' => $email,
        'password' => Hash::make('senha123'),
        'role' => RoleEnum::TECNICO->value,
        'code_hash' => hash('sha256', $code),
        'attempts' => 4, // 5th attempt will lock out
    ]), now()->addMinutes(15));

    $response = $this->withSession(['cadastro_email' => $email])
        ->post(route('cadastro.verify'), ['code' => '999999']);

    $response->assertRedirect(route('cadastro.index'));
    $response->assertSessionHasErrors('code');

    expect(Cache::has("cadastro_pendente:{$email}"))->toBeFalse();
});

test('verify creates registration request and sends confirmation email on correct code', function () {
    Mail::fake();

    $email = 'aprovado@ifpr.edu.br';
    $code = '654321';

    Cache::put("cadastro_pendente:{$email}", Crypt::encrypt([
        'nome' => 'Docente Aprovado',
        'email' => $email,
        'password' => Hash::make('senhaSegura123'),
        'role' => RoleEnum::DOCENTE_ESPECIAL,
        'code_hash' => hash('sha256', $code),
        'attempts' => 0,
        'campos' => [],
    ]), now()->addMinutes(15));

    $response = $this->withSession(['cadastro_email' => $email])
        ->post(route('cadastro.verify'), ['code' => $code]);

    $response->assertRedirect(route('cadastro.enviado'));

    Mail::assertQueued(SolicitacaoRegistroEnviada::class, function ($mail) use ($email) {
        return $mail->hasTo($email) && $mail->nome === 'Docente Aprovado';
    });

    $solicitacao = SolicitacaoRegistro::where('email', $email)->first();
    expect($solicitacao)->not->toBeNull()
        ->and($solicitacao->status)->toBe(StatusSolicitacaoRegistroEnum::PENDENTE);

    expect(Cache::has("cadastro_pendente:{$email}"))->toBeFalse();
});

test('accepting registration request creates user and sends acceptance email', function () {
    Mail::fake();

    $admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $curso = Curso::factory()->create();
    $disciplina = Disciplina::factory()->create(['curso_id' => $curso->id]);

    $solicitacao = SolicitacaoRegistro::create([
        'nome' => 'Novo Professor',
        'email' => 'novo@ifpr.edu.br',
        'password' => Hash::make('senha12345'),
        'role' => RoleEnum::PROFESSOR_REGULAR,
        'status' => StatusSolicitacaoRegistroEnum::PENDENTE,
    ]);
    $solicitacao->disciplinas()->attach($disciplina->id);

    $response = $this->actingAs($admin)
        ->post(route('cadastro.accept', ['solicitacao' => $solicitacao]));

    $response->assertRedirect(route('solicitacoes-registro.index'));

    Mail::assertQueued(SolicitacaoRegistroAceita::class, function ($mail) {
        return $mail->hasTo('novo@ifpr.edu.br') && $mail->newUser->nome === 'Novo Professor';
    });

    $user = User::where('email', 'novo@ifpr.edu.br')->first();
    expect($user)->not->toBeNull()
        ->and(SolicitacaoRegistro::find($solicitacao->id))->toBeNull()
        ->and($user->disciplinas->contains('id', $disciplina->id))->toBeTrue();
});

test('declining registration request removes record and sends rejection email with observation', function () {
    Mail::fake();

    $admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);

    $solicitacao = SolicitacaoRegistro::create([
        'nome' => 'Recusado Docente',
        'email' => 'recusado@ifpr.edu.br',
        'password' => Hash::make('senha12345'),
        'role' => RoleEnum::PROFESSOR_REGULAR,
        'status' => StatusSolicitacaoRegistroEnum::PENDENTE,
    ]);

    $response = $this->actingAs($admin)
        ->post(route('cadastro.decline', ['solicitacao' => $solicitacao]), [
            'observacao' => 'Email institucional não confere.',
        ]);

    $response->assertRedirect(route('solicitacoes-registro.index'));

    Mail::assertQueued(SolicitacaoRegistroRecusada::class, function ($mail) {
        return $mail->hasTo('recusado@ifpr.edu.br')
            && $mail->nome === 'Recusado Docente'
            && $mail->observacao === 'Email institucional não confere.';
    });

    expect(SolicitacaoRegistro::find($solicitacao->id))->toBeNull();
});

test('unauthorized user cannot accept or decline registration requests', function () {
    $tecnico = User::factory()->create(['role' => RoleEnum::TECNICO]);

    $solicitacao = SolicitacaoRegistro::create([
        'nome' => 'Teste Auth',
        'email' => 'auth@ifpr.edu.br',
        'password' => Hash::make('senha12345'),
        'role' => RoleEnum::PROFESSOR_REGULAR,
        'status' => StatusSolicitacaoRegistroEnum::PENDENTE,
    ]);

    $this->actingAs($tecnico)
        ->post(route('cadastro.accept', ['solicitacao' => $solicitacao]))
        ->assertStatus(404);

    $this->actingAs($tecnico)
        ->post(route('cadastro.decline', ['solicitacao' => $solicitacao]))
        ->assertStatus(404);
});

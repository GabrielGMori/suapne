<?php

use App\Enums\RoleEnum;
use App\Http\Requests\AtendimentoSemanalRequest;
use App\Http\Requests\SolicitacaoRegistroRequest;
use App\Models\Disciplina;
use App\Models\SolicitacaoRegistro;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('applies max validation to database-backed string fields', function () {
    $solicitacaoRules = (new SolicitacaoRegistroRequest)->rules();
    $atendimentoRules = (new AtendimentoSemanalRequest)->rules();

    expect($solicitacaoRules['nome'])->toContain('max:200')
        ->and($solicitacaoRules['email'])->toContain('max:200')
        ->and($solicitacaoRules['password'])->toContain('max:200')
        ->and($atendimentoRules['local'])->toContain('max:100');
});

it('creates a user with the original password when approving a registration request', function () {
    $curso = \App\Models\Curso::factory()->create();
    $disciplina = Disciplina::factory()->create(['curso_id' => $curso->id]);
    $solicitacao = SolicitacaoRegistro::create([
        'nome' => 'Maria Teste',
        'email' => 'maria@teste.com',
        'password' => Hash::make('senha123'),
        'role' => RoleEnum::PROFESSOR_REGULAR,
        'status' => 'PENDENTE',
    ]);
    $solicitacao->disciplinas()->attach($disciplina->id);

    $user = $solicitacao->createUser();

    expect($user->email)->toBe('maria@teste.com')
        ->and(Hash::check('senha123', $user->password))->toBeTrue()
        ->and($user->disciplinas->pluck('id')->contains($disciplina->id))->toBeTrue();
});

it('sends rejection email with observation when declining registration request', function () {
    \Illuminate\Support\Facades\Mail::fake();

    $admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $solicitacao = SolicitacaoRegistro::create([
        'nome' => 'Joao Recusado',
        'email' => 'joao@teste.com',
        'password' => Hash::make('senha123'),
        'role' => RoleEnum::PROFESSOR_REGULAR,
        'status' => 'PENDENTE',
    ]);

    $response = $this->actingAs($admin)
        ->post(route('cadastro.decline', ['solicitacao' => $solicitacao]), [
            'observacao' => 'Documentação incompleta.',
        ]);

    $response->assertRedirect(route('solicitacoes-registro.index'));

    \Illuminate\Support\Facades\Mail::assertQueued(\App\Mail\SolicitacaoRegistroRecusada::class, function ($mail) {
        return $mail->hasTo('joao@teste.com')
            && $mail->nome === 'Joao Recusado'
            && $mail->observacao === 'Documentação incompleta.';
    });

    expect(SolicitacaoRegistro::find($solicitacao->id))->toBeNull();
});


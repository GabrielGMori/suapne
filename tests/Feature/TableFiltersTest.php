<?php

use App\Models\User;
use App\Models\Estudante;
use App\Tables\AtendimentoSemanalTable;
use App\Tables\AuditTable;
use App\Tables\ContasCnapneTable;
use App\Tables\ContasProfessorTable;
use App\Tables\CursoTable;
use App\Tables\DisciplinaTable;
use App\Tables\EstudanteTable;
use App\Tables\PlanoFlexibilizacaoCurricularTable;
use App\Tables\PlanoTrabalhoEstudanteTable;
use App\Tables\SolicitacaoRegistroTable;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $user = User::first() ?? User::factory()->create();
    Auth::login($user);
});

it('can apply all filters across all tables without query errors', function () {
    $tables = [
        AtendimentoSemanalTable::class,
        AuditTable::class,
        ContasCnapneTable::class,
        ContasProfessorTable::class,
        CursoTable::class,
        DisciplinaTable::class,
        EstudanteTable::class,
        PlanoFlexibilizacaoCurricularTable::class,
        PlanoTrabalhoEstudanteTable::class,
        SolicitacaoRegistroTable::class,
    ];

    foreach ($tables as $tableClass) {
        $table = new $tableClass();
        $filters = $table->filters();

        expect($filters)->toBeArray();

        foreach ($filters as $filter) {
            $query = $table->query();

            $val = match ($filter->getType()) {
                'multiselect' => ['1'],
                'date', 'datetime' => '2026-01-01',
                'number' => 1,
                default => 'teste',
            };

            $filter->apply($query, $val);

            // Verify query generates valid SQL and executes without exception
            expect(fn () => $query->count())->not->toThrow(Throwable::class);
        }
    }
});

it('matches students by cpf and phone regardless of formatting', function () {
    $curso = \App\Models\Curso::first() ?? \App\Models\Curso::factory()->create(['quantidade_periodos' => 4]);

    $estudante = Estudante::first() ?? Estudante::factory()->create([
        'curso_id' => $curso->id,
        'cpf' => '123.456.789-00',
        'telefone' => '(41) 98765-4321',
    ]);

    $table = new EstudanteTable();
    $cpfFilter = collect($table->filters())->first(fn ($f) => $f->getKey() === 'cpf');
    $phoneFilter = collect($table->filters())->first(fn ($f) => $f->getKey() === 'telefone');

    expect($cpfFilter)->not->toBeNull()
        ->and($phoneFilter)->not->toBeNull();

    // Test with unformatted digits
    $digits = preg_replace('/\D/', '', $estudante->cpf);
    $query = $table->query();
    $cpfFilter->apply($query, $digits);
    expect($query->where('id', $estudante->id)->exists())->toBeTrue();

    // Test with formatted cpf string
    $queryFormatted = $table->query();
    $cpfFilter->apply($queryFormatted, $estudante->cpf);
    expect($queryFormatted->where('id', $estudante->id)->exists())->toBeTrue();

    // Test with unformatted phone digits
    $phoneDigits = preg_replace('/\D/', '', $estudante->telefone);
    $queryPhone = $table->query();
    $phoneFilter->apply($queryPhone, $phoneDigits);
    expect($queryPhone->where('id', $estudante->id)->exists())->toBeTrue();

    // Test with formatted phone string
    $queryPhoneFormatted = $table->query();
    $phoneFilter->apply($queryPhoneFormatted, $estudante->telefone);
    expect($queryPhoneFormatted->where('id', $estudante->id)->exists())->toBeTrue();
});

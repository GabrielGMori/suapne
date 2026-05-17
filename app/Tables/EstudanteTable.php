<?php

namespace App\Tables;

use App\Models\Estudante;
use App\Support\FakeBuilder;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewConfig;
use App\View\Components\ListViewFilter;
use Illuminate\Database\Eloquent\Builder;

class EstudanteTable extends ListViewConfig
{
    private const SEED = [
        ['id' => 1, 'nome' => 'Ana Carolina Lima', 'curso' => 'Engenharia de Software', 'periodo' => 6, 'situacao' => 'Matriculado', 'matricula' => '2021001', 'avatar' => null, 'email_pessoal' => 'ana@gmail.com', 'email_academico' => 'ana@uni.edu', 'cpf' => '111.111.111-11'],
        ['id' => 2, 'nome' => 'Bruno Henrique Melo', 'curso' => 'Ciência da Computação', 'periodo' => 4, 'situacao' => 'Matriculado', 'matricula' => '2022045', 'avatar' => null, 'email_pessoal' => 'bruno@gmail.com', 'email_academico' => 'bruno@uni.edu', 'cpf' => '222.222.222-22'],
        ['id' => 3, 'nome' => 'Carla Beatriz Souza', 'curso' => 'Sistemas de Informação', 'periodo' => 8, 'situacao' => 'Formado', 'matricula' => '2018033', 'avatar' => null, 'email_pessoal' => 'carla@gmail.com', 'email_academico' => 'carla@uni.edu', 'cpf' => '333.333.333-33'],
    ];

    public function query(): Builder
    {
        return FakeBuilder::make(Estudante::class, self::SEED);
    }

    public function title(): ?string { return 'Estudantes registrados'; }

    public function createUrl(): ?string { return '#'; }

    public function createLabel(): ?string { return 'Registrar Novo'; }

    public function emptyMessage(): string { return 'Nenhum estudante foi encontrado'; }

    public function icon(): \Closure
    {
        return fn(Estudante $item) => $item->avatar
            ? asset($item->avatar)
            : asset('storage/img/placeholder-user.png');
    }

    public function imageIcon(): bool { return true; }

    public function columns(): array
    {
        $statusCache = [];

        return [
            ListViewColumn::make('nome')->label('Nome do estudante')->size('large'),
            ListViewColumn::make('curso')->label('Curso do estudante')->size('large'),
            ListViewColumn::make('periodo')->label('Período')->size('small')->format(
                fn($value) => $value . '°'
            ),
            ListViewColumn::make('situacao')->label('Situação')->format(
                function ($value) use (&$statusCache) {
                    return $statusCache[$value] ??= view('components.status', [
                        'color' => 'dark',
                        'label' => $value,
                    ])->render();
                }
            ),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('curso')->label('Curso do estudante')->size('large'),
            ListViewFilter::make('periodo')->label('Período')->size('tiny'),
            ListViewFilter::make('situacao')
                ->label('Situação')
                ->type('multiselect')
                ->options(['Matriculado', 'Formado', 'Evadido']),
            ListViewFilter::make('matricula')->label('Matrícula')->hidden(),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#'),
        ];
    }
}

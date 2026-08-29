<?php

use App\View\Components\ListViewAction;
use App\View\Components\ListViewFilter;

it('adds the shared trashed filter config', function () {
    $filter = ListViewFilter::make('excluido')->trashed();

    expect($filter->getType())->toBe('select')
        ->and($filter->getOptions())->toMatchArray([
            0 => 'Não',
            1 => 'Sim',
        ])
        ->and($filter->isHidden())->toBeTrue();
});

it('adds the shared restore action behavior for trashed items', function () {
    $item = new class {
        public function trashed(): bool
        {
            return true;
        }
    };

    $action = ListViewAction::make(fn () => '/estudantes/1')
        ->restoreOnTrashed(fn () => '/estudantes/1/restore', 'Deseja restaurar este estudante?');

    expect($action->getUrl($item))->toBe('/estudantes/1/restore')
        ->and($action->getMethod($item))->toBe('POST')
        ->and($action->getIcon($item))->toBe('restore')
        ->and($action->getColor($item))->toBe('primary')
        ->and($action->needsConfirmation($item))->toBeTrue()
        ->and($action->getConfirmMessage($item))->toBe('Deseja restaurar este estudante?');
});

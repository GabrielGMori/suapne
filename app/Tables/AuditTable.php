<?php

namespace App\Tables;

use App\Support\ModelLabels;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewConfig;
use App\View\Components\ListViewFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use OwenIt\Auditing\Models\Audit;

class AuditTable extends ListViewConfig
{
    private array $modelNameCache = [];

    public function query(): Builder
    {
        return Audit::query()->latest();
    }

    public function title(): ?string
    {
        return 'Ações registradas no sistema';
    }

    public function emptyMessage(): string
    {
        return 'Nenhuma ação foi encontrada';
    }

    public function icon(): \Closure
    {
        return fn ($item) => $item->user?->avatar
            ? asset($item->user->avatar)
            : asset('storage/img/placeholder-user.png');
    }

    public function imageIcon(): bool
    {
        return true;
    }

    private function actionMessage(Audit $audit): string
    {
        return match ($audit->event) {
            'created' => 'Criação',
            'deleted' => 'Exclusão',
            'updated' => 'Edição',
            'restored' => 'Restauração',
            default => $audit->event,
        };
    }

    private function actionColor(Audit $audit): string
    {
        return match ($audit->event) {
            'created' => 'success',
            'deleted' => 'danger',
            'updated' => 'warning',
            'restored' => 'info',
            default => 'dark',
        };
    }

    private function auditableDescription(Audit $item, $value): string
    {
        $label = ModelLabels::label($item->auditable_type);

        if ($item->auditable === null) {
            $name = $item->old_values['nome'] ?? ($item->new_values['nome'] ?? '');
            $name = $name === '' ? $name : "\"{$name}\"";

            return "{$label} {$name} (excluído)";
        }

        $name = $value?->nome ?? 'sem nome';

        return "{$label} \"{$name}\"";
    }

    private const EXCLUDED_ATTRIBUTES = ['id', 'password'];

    private function formatValue(string $attribute, mixed $value): mixed
    {
        if ($value === null || ! str_ends_with($attribute, '_id')) {
            return $value;
        }

        $modelClass = 'App\\Models\\'.Str::studly(Str::beforeLast($attribute, '_id'));

        if (! class_exists($modelClass)) {
            return $value;
        }

        $cacheKey = "{$modelClass}:{$value}";

        if (! array_key_exists($cacheKey, $this->modelNameCache)) {
            $this->modelNameCache[$cacheKey] = $modelClass::find($value)?->nome;
        }

        return $this->modelNameCache[$cacheKey] ?? "ID {$value} (registro removido)";
    }

    private function buildModified(Audit $audit): array
    {
        $old = $audit->old_values ?? [];
        $new = $audit->new_values ?? [];
        $attributes = array_unique(array_merge(array_keys($old), array_keys($new)));

        $modified = [];

        foreach ($attributes as $attribute) {
            if (in_array($attribute, self::EXCLUDED_ATTRIBUTES, true)) {
                continue;
            }

            $entry = [];

            if (array_key_exists($attribute, $old)) {
                $entry['old'] = $this->formatValue($attribute, $old[$attribute]);
            }

            if (array_key_exists($attribute, $new)) {
                $entry['new'] = $this->formatValue($attribute, $new[$attribute]);
            }

            $modified[$attribute] = $entry;
        }

        return $modified;
    }

    private function changesLabel(Audit $audit, int $count): string
    {
        $noun = match ($audit->event) {
            'created' => $count === 1 ? 'campo definido' : 'campos definidos',
            'deleted' => $count === 1 ? 'campo removido' : 'campos removidos',
            'restored' => $count === 1 ? 'campo restaurado' : 'campos restaurados',
            default => $count === 1 ? 'campo alterado' : 'campos alterados',
        };

        return "{$count} {$noun}";
    }

    public function columns(): array
    {
        $statusCache = [];

        return [
            ListViewColumn::make('user.nome')->label('Nome do autor')
                ->format(fn ($value, $item) => $value ?? ($item['new_values']['nome'] ?? ($item['old_values']['nome'] ?? 'Autor não encontrado'))),

            ListViewColumn::make('event')->label('O que foi feito?')->size('small')
                ->format(function ($value, $item) use (&$statusCache) {
                    $msg = $this->actionMessage($item);

                    return $statusCache[$msg] ??= view('components.status', [
                        'color' => $this->actionColor($item),
                        'label' => $msg,
                    ])->render();
                }),

            ListViewColumn::make('auditable')->label('O que foi alterado?')
                ->format(fn ($value, $item) => $this->auditableDescription($item, $value)),

            ListViewColumn::make('created_at')->label('Data')->size('small')
                ->format(fn ($value) => $value->format('d/m/Y \à\s H:i')),

            ListViewColumn::make('changes')->label('Modificado')->size('small')
                ->format(function ($value, $item) {
                    $modified = $this->buildModified($item);
                    $count = count($modified);

                    if ($count === 0) {
                        return '---';
                    }

                    return view('components.modal.audit', [
                        'modified' => $modified,
                        'label' => $this->changesLabel($item, $count),
                    ])->render();
                }),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('user')
                ->foreignKey('nome')
                ->label('Nome do autor')
                ->size('large'),

            ListViewFilter::make('event')
                ->label('Tipo de ação')
                ->type('multiselect')
                ->options([
                    'created' => 'Criação',
                    'updated' => 'Edição',
                    'deleted' => 'Exclusão',
                    'restored' => 'Restauração',
                ]),

            ListViewFilter::make('auditable_type')
                ->label('Tipo de registro alterado')
                ->type('multiselect')->size('large')
                ->options(ModelLabels::options()),

            ListViewFilter::make('created_at_start')
                ->label('Data inicial')
                ->size('small')
                ->type('date')
                ->startingDateInterval('created_at'),

            ListViewFilter::make('created_at_end')
                ->label('Data final')
                ->size('small')
                ->type('date')
                ->endingDateInterval('created_at'),
        ];
    }
}

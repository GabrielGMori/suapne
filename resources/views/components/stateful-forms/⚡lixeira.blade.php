<?php

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Support\ModelLabels;
use App\View\Components\ListViewAction;
use Illuminate\Support\Str;

new class extends Component
{
    public ?string $config = null;

    #[Url(as: 'model', keep: true)]
    public null|string|array $model = null;

    public function mount(): void
    {
        $this->resolveConfig($this->model);
    }

    public function updatedModel($modelName): void
    {   
        $this->resolveConfig($modelName);
    }

    private function resolveConfig($modelName): void
    {
        $selected = is_array($modelName) ? ($modelName[0] ?? null) : $modelName;

        if (empty($selected)) {
            $this->config = null;
            return;
        }

        $tableName = str_replace('Models', 'Tables', $selected . 'Table');
        $this->config = class_exists($tableName) ? $tableName : null;
    }

    public function getConfigInstance(): mixed
    {
        if (! $this->config || ! class_exists($this->config)) {
            return null;
        }

        return new ($this->config);
    }
};
?>

<div>
    <livewire:form.select 
        :options="ModelLabels::tableOptions()" 
        wire:model.live="model" 
        appearance="outlined" 
        label="Tipo de registro" 
    />

    <hr class="mt-3 mb-5 text-on-surface">
    
    @if ($config && $configInstance = $this->getConfigInstance())
        <div wire:key="lixeira-{{ $config }}">
            <livewire:list-view 
                :config="$config" 
                :query="$configInstance->query()->onlyTrashed()" 
                :can-create="false"
                :title="$configInstance->title() . ' (excluídos)'"
                filters-color="secondary"
                empty-message="Nenhum registro encontrado na lixeira"
            />
        </div>
    @else
        <h4 class="text-body-large">Por favor, selecione um tipo de registro</h4>
    @endif
</div>

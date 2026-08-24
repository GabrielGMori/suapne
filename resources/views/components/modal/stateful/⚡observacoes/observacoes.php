<?php

namespace App\Livewire\Modal\Stateful;

use App\Models\Estudante;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public Estudante $estudante;

    public string $observacao = '';

    public function save(): void
    {
        $this->validate([
            'observacao' => ['required', 'string', 'max:1000'],
        ]);

        $this->estudante->observacoes()->create([
            'observacao' => $this->observacao,
            'user_id' => Auth::user()->id,
        ]);

        $this->reset('observacao');
        $this->dispatch('close-modal', 'modal-observacoes');
        $this->dispatch('observacao-added');
        $this->dispatch('refresh-page');
    }
};

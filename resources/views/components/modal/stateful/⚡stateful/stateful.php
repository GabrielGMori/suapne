<?php

use App\Models\Estudante;
use Livewire\Component;

new class extends Component {
    public bool $show = false;
    public string $title = '';
    public string $width = 'xl';

    public Estudante $estudante;
    public string $observacao = '';

    public function open(): void
    {
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
    }

    public function save(): void
    {
        $this->validate([
            'observacao' => ['required', 'string'],
        ]);

        $this->estudante->observacoes()->create([
            'observacao' => $this->observacao,
        ]);

        $this->reset('observacao');
        $this->close();
    }
};

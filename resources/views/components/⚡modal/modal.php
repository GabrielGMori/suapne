<?php

use Livewire\Component;

new class extends Component {
    public bool $show = false;
    public bool $stateful = false;
    public string $title = '';
    public string $size = 'xl';

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
        if ($this->onConfirm) {
            ($this->onConfirm)();
        }
        $this->close();
    }

};
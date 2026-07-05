<?php
// resources/views/livewire/form/avatar-upload.blade.php

use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $name = 'avatar';
    public ?string $defaultImgPath = null;
    public ?string $previewImgPath = null;
    public $uploadedImg;

    public function mount(): void
    {
        $this->previewImgPath = $this->defaultImgPath;
    }

    public function updatedUploadedImg() : void
    {
        $this->validate([
            'uploadedImg' => 'image|max:10240' // 10 MB
        ]);
        $this->previewImgPath = $this->uploadedImg->temporaryUrl();
    }

    public function removeImage() : void
    {
        $this->uploadedImg = null;
        $this->previewImgPath = null;
    }

    public function restoreImage() : void
    {
        $this->uploadedImg = null;
        $this->previewImgPath = $this->defaultImgPath;
    }
};

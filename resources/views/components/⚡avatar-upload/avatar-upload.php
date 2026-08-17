<?php

use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public string $name = 'avatar';
    public ?string $defaultImgPath = null;
    public ?string $previewImgPath = null;
    public ?string $storedImgPath = null;
    public $uploadedImg;

    public function mount(): void
    {
        $this->previewImgPath = $this->defaultImgPath;
        $this->storedImgPath = $this->defaultImgPath;
    }

    public function updatedUploadedImg() : void
    {
        $this->validate([
            'uploadedImg' => 'image|max:10240' // 10 MB
        ]);
        $path = $this->uploadedImg->store('uploads/avatars', 'public');

        $this->storedImgPath = 'storage/' . $path;
        $this->previewImgPath = $this->storedImgPath;
    }

    public function removeImage() : void
    {
        $this->uploadedImg = null;
        $this->previewImgPath = null;
        $this->storedImgPath = null;
    }

    public function restoreImage() : void
    {
        $this->uploadedImg = null;
        $this->previewImgPath = $this->defaultImgPath;
        $this->storedImgPath = $this->defaultImgPath;
    }
};

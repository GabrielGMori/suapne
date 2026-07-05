<div {{ $attributes->merge(['class' => "flex flex-col gap-2 place-items-center"]) }} x-data>
    <input type="hidden" name="{{ $name }}" value="{{ $storedImgPath }}">

    <div class="flex">
        <img src="{{ $previewImgPath ? (str_starts_with($previewImgPath, 'http') ? $previewImgPath : asset($previewImgPath)) : asset('storage/img/placeholder-user.png') }}" alt="Usuário"
             class="h-50 w-50 object-cover rounded-full shrink-0">
        <x-button icon="replay" color="transparent" wire:click="restoreImage" x-on:click="$refs.avatarInput.value = null" @class([
                'absolute ml-45 transition-transform duration-200 hover:-rotate-45',
                'invisible' => !$defaultImgPath || $defaultImgPath === $previewImgPath
            ])/>
    </div>

    <input x-ref="avatarInput" id="avatar-upload-{{ $name }}" type="file" wire:model="uploadedImg" accept="image/*" hidden>

    @error('uploadedImg')
        <span class="text-error">{{ $message }}</span>
    @enderror
    @error($name)
        <span class="text-error">{{ $message }}</span>
    @enderror

    <div class="btn btn-tertiary cursor-pointer text-body-medium">
        <label for="avatar-upload-{{ $name }}" class="cursor-pointer select-none">Enviar arquivo</label>
        <x-icon icon="upload_file" size="26"/>
    </div>

    <x-button label="Remover imagem" color="red" wire:click="removeImage" x-on:click="$refs.avatarInput.value = null"/>
</div>

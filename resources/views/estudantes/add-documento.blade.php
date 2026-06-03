<x-layouts.main title="Adicionar documento">
    <div class="flex items-end justify-between mb-10">
        <div class="flex items-center gap-10">
        <livewire:form.input disabled type="text" label="Nome do documento" appearance="outlined"/>
        <livewire:form.input disabled type="file" label="Arquivo" appearance="outlined"/>
        </div>
        <x-button color="secondary" icon="add"/>
    </div>
    <hr class="text-on-surface">
    <div class="flex flex-col gap-10 mt-10">
        <div class="flex">
            <x-documento name="Entrevista com o estudante" icon="draft" actionIcon="download" class="grow">
                <x-slot:metadata>
                    <p>Enviada por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                    <p>Data de envio: {{ now()->format('d/m/Y') }}</p>
                    <x-button icon="delete" color="transparent"/>
                </x-slot:metadata>
            </x-documento>
        </div>
        <div class="flex justify-end gap-2">
            <x-button label="Cancelar" type="link" href="{{ route('estudantes.show', ['id' => $estudante->id]) }}" color="red"/>
            <x-button label="Adicionar (Em breve)" disabled/>
        </div>
    </div>
</x-layouts.main>

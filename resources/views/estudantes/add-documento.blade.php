<x-layouts.main title="Adicionar documento">
    <div class="flex items-end justify-between mb-10">
        <div class="flex items-center gap-10">
        <livewire:form.input type="text" label="Nome do documento" appearance="outlined"/>
        <livewire:form.input type="file" label="Arquivo" appearance="outlined"/>
        </div>
        <x-button color="secondary" icon="add"/>
    </div>
    <hr class="text-on-surface">
    <div class="flex flex-col gap-10 mt-10">
    <x-documento name="Entrevista com o estudante" actionIcon="download" actionUrl="#" icon="draft">
                    <x-slot:metadata>
                        <p>Enviada por: {{ \App\Models\User::inRandomOrder()->first()->nome }}</p>
                        <p>Data de envio: 30/03/2026 </p>
                    </x-slot:metadata>
    </x-documento>
    <x-button icon="add" label="Adicionar"/>
    </div>
</x-layouts.main>

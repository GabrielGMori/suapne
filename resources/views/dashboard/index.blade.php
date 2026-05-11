<x-layouts.main title="Olá, nome do Docente!">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-11 space-y-10">

            <div class="flex items-start gap-4">
                <i class="material-symbols-outlined shrink-0 text-black-800" style="font-size: 5rem; margin-top: -10px;">
                    person_alert
                </i>
                <div class="flex-1 space-y-3">
                    <p class="text-display-medium">
                        Existe 1 solicitação de cadastro aguardando aprovação
                    </p>
                    <x-button label="ver solicitações" color="tertiary" />
                </div>
            </div>

            <hr class="border-t border-gray-200 my-8">

            <div class="flex items-start gap-4">
            </div>


        </div>


        <div class="lg:col-span-11 space-y-10">

            <div class="flex items-start gap-4">
                <i class="material-symbols-outlined shrink-0 text-black-800"
                    style="font-size: 5rem; margin-top: -10px;">
                    notification_important
                </i>
                <div class="flex-1 space-y-3">
                    <p class="text-display-medium">
                        Existem 4 PTEs aguardando revisão
                    </p>
                    <x-button label="ver PTEs" color="tertiary" />
                </div>
            </div>

            <hr class="border-t border-gray-200 my-8">

            <div class="flex items-start gap-4">

            </div>
            <div class="lg:col-span-11 space-y-10">

                <div class="flex items-start gap-4">
                    <i class="material-symbols-outlined shrink-0 text-black-800"
                        style="font-size: 5rem; margin-top: -10px;">
                        article_person
                    </i>
                    <div class="flex-1 space-y-3">
                        <p class="text-display-medium">
                            Iniciar atendimento semanal
                        </p>

                        <div style="display: flex; gap: 10px;">
                            <x-form-input type="text" label="Estudante" appearance="outlined" />
                           <x-button label="Size default" />
                        </div>








                    </div>
</x-layouts.main>

<x-layouts.main title="Olá, nome do Docente!">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-10">

            <div class="flex items-start gap-4">
                <i class="material-symbols-outlined shrink-0 text-black-800"
                    style="font-size: 5rem; margin-top: -10px;">
                    person_alert
                </i>
                <div class="flex-1 space-y-3">
                    <p class="text-display-medium">
                        Existe 1 solicitação de cadastro aguardando aprovação
                    </p>
                    <x-button label="ver solicitações" color="tertiary" />
                </div>
            </div>

            <hr class="border-t border-gray-200">

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

            <hr class="border-t border-gray-200">

            <div class="flex items-start gap-4">
                <i class="material-symbols-outlined shrink-0 text-black-800"
                    style="font-size: 5rem; margin-top: -10px;">
                    article_person
                </i>
                <div class="flex-1 space-y-3">
                    <p class="text-display-medium">
                        Iniciar atendimento semanal
                    </p>
                    <div class="flex items-end gap-4">
                        <div class="w-full max-w-sm">
                            <livewire:form.input label="Estudante" appearance="outlined" />
                        </div>
                        <x-button label="Iniciar atendimento" />
                    </div>
                </div>
            </div>

            <hr class="border-t border-gray-200">

            <div class="flex items-start gap-4">
                <i class="material-symbols-outlined shrink-0 text-black-800"
                    style="font-size: 5rem; margin-top: -10px;">
                    add_notes
                </i>
                <div class="flex-1 space-y-3">
                    <p class="text-display-medium">
                        Criar Plano de Trabalho do Estudante
                    </p>
                    <div class="flex items-end gap-4">
                        <div class="w-full max-w-sm">
                            <livewire:form.input label="Estudante" appearance="outlined" />
                        </div>
                        <x-button label="Criar PTE" />
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-10">
            </div>


            <div class="lg:col-span-1 space-y-4">

                <h3 class="text-2xl font-normal text-gray-800">
                    Últimas alterações
                </h3>

                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 space-y-3 shadow-sm">

                    <div
                        class="flex items-center justify-between gap-3 p-2 hover:bg-white rounded-lg transition duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center shrink-0">
                                <i class="material-symbols-outlined text-gray-600 text-xl">person</i>
                            </div>

                            <div class="text-sm text-gray-700">
                                <span class="font-medium text-gray-900">Maria Silva</span> editou o campo "nome" da
                                estudante <span class="font-medium text-gray-900">Joana Carvalho</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-xs text-gray-400 whitespace-nowrap shrink-0">
                            <span>2 horas atrás</span>
                            <i
                                class="material-symbols-outlined text-sm cursor-pointer hover:text-gray-600">open_in_new</i>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between gap-3 p-2 hover:bg-white rounded-lg transition duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center shrink-0">
                                <i class="material-symbols-outlined text-gray-600 text-xl">person</i>
                            </div>
                            <div class="text-sm text-gray-700">
                                <span class="font-medium text-gray-900">Maria Silva</span> editou o campo "nome" da
                                estudante <span class="font-medium text-gray-900">Joana Carvalho</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-400 whitespace-nowrap shrink-0">
                            <span>2 horas atrás</span>
                            <i
                                class="material-symbols-outlined text-sm cursor-pointer hover:text-gray-600">open_in_new</i>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between gap-3 p-2 hover:bg-white rounded-lg transition duration-200">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center shrink-0">
                                <i class="material-symbols-outlined text-gray-600 text-xl">person</i>
                            </div>
                            <div class="text-sm text-gray-700">
                                <span class="font-medium text-gray-900">Maria Silva</span> editou o campo "nome" da
                                estudante <span class="font-medium text-gray-900">Joana Carvalho</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-400 whitespace-nowrap shrink-0">
                            <span>2 horas atrás</span>
                            <i
                                class="material-symbols-outlined text-sm cursor-pointer hover:text-gray-600">open_in_new</i>
                        </div>
                    </div>





                </div>
</x-layouts.main>
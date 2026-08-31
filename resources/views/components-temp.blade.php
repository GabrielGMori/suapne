<x-layouts.main title="Componentes">
    <div class="flex flex-col bg-white rounded-lg border border-surface gap-5 p-5 text-black mb-5">
        <h2 class="text-headline-medium">Componentes White</h2>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Modal (Stateless)
            </summary>
            <div class="flex flex-col gap-5">
                <x-modal title="sdjfaslkjfsalk" size="70vh" label="danger" color="secondary">
                    <h1>OI MEUS AMIGOS</h1>
                </x-modal>
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Upload Avatar
            </summary>
            <div class="flex flex-col gap-5">
                <livewire:avatar-upload default-img-path="storage/img/logo-ifpr.png" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                List View
            </summary>
            <div class="flex flex-col gap-5">
                <livewire:list-view
                    config="App\Tables\EstudanteTable"
                    title="Estudantes teste"
                    create-url="#"
                    create-label="Novo Estudante"
                    empty-message="Nenhum estudante foi encontrado"
                />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Form Inputs
            </summary>
            <div class="flex flex-col gap-5">
                <livewire:form.select type="select" :options="['Matemática', 'Português', 'Artes']" placeholder="Disciplina" appearance="surface" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Status
            </summary>
            <div class="flex flex-col gap-5 mt-2">
                <div class="flex gap-2">
                    <x-status label="Pendente" color="danger" />
                    <x-status label="Aguardando" color="warning" />
                    <x-status label="Aprovado" color="success" />
                    <x-status label="Pré-visualização" color="info" />
                    <x-status label="Matriculado" color="dark" />
                </div>
                <div class="flex gap-2">
                    <x-status label="Pendente" color="danger" :filled="false" />
                    <x-status label="Aguardando" color="warning" :filled="false" />
                    <x-status label="Aprovado" color="success" :filled="false" />
                    <x-status label="Pré-visualização" color="info" :filled="false" />
                    <x-status label="Matriculado" color="dark" :filled="false" />
                </div>
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Seção Expansível
            </summary>
            <div class="mt-2">
                <x-secao-expansivel.bottom title="Dados gerais">
                    <div class="flex gap-8">
                        <div class="shrink-0 flex items-start justify-center">
                            <div
                                class="w-32 h-32 bg-[#a9a9a9] rounded-full flex items-center justify-center text-[#f4f4f4] overflow-hidden">
                                <x-icon color="white" size="80">person</x-icon>
                            </div>
                        </div>

                        <div class="grow grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                            <x-display-dado label="Nome:" value="Ricardo Borges" />
                            <x-display-dado label="Matrícula:" value="20250000001" />

                            <x-display-dado label="Ingresso:" value="2025/1" />
                            <x-display-dado label="Período:" value="1º" />

                            <x-display-dado label="Curso:" value="Técnico em Informática" />
                            <x-display-dado label="Quant. de períodos do curso:" value="1º" />

                            <x-display-dado label="E-mail pessoal:" value="Emailpessoal@email.com" />
                            <x-display-dado label="E-mail Acadêmico:" value="Emailacademico@email.com" />

                            <x-display-dado label="Telefone:" value="(41) 91234-5678" />
                            <x-display-dado label="Data de nascimento:" value="01/01/2008" />
                        </div>
                    </div>

                    <x-slot:hidden>
                        <div class="flex gap-8 justify-end align-end ml-38">

                            <div class="grow grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                                <x-display-dado label="Nome:" value="Ricardo Borges" />
                                <x-display-dado label="Matrícula:" value="20250000001" />

                                <x-display-dado label="Ingresso:" value="2025/1" />
                                <x-display-dado label="Período:" value="1º" />

                                <x-display-dado label="Curso:" value="Técnico em Informática" />
                                <x-display-dado label="Quant. de períodos do curso:" value="1º" />

                                <x-display-dado label="E-mail pessoal:" value="Emailpessoal@email.com" />
                                <x-display-dado label="E-mail Acadêmico:" value="Emailacademico@email.com" />

                                <x-display-dado label="Telefone:" value="(41) 91234-5678" />
                                <x-display-dado label="Data de nascimento:" value="01/01/2008" />
                            </div>
                        </div>
                    </x-slot:hidden>

                </x-secao-expansivel.bottom>
            </div>
        </details>

    </div>
    <div class="flex flex-col bg-surface rounded-lg border border-black gap-5 p-5 mb-5">
        <h2 class="text-headline-medium">Componentes Surface</h2>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Form Inputs
            </summary>
            <div class="flex flex-col gap-5">
                <x-form.input label="Nome completo" name="nome-outlined" appearance="outlined" />
                <livewire:form.select type="select" label="Componente curricular" name="componente-outlined" :options="['Matemática', 'Português', 'Artes']" appearance="outlined" placeholder="Selecionar" />
                <livewire:form.select type="select" size="tiny" value="20" name="number-outlined" :options="['20', '10', '5']" appearance="outlined" />
                <livewire:form.select type="multiselect" label="Componentes curriculares" name="componentes-outlined" :options="['Matemática', 'Português', 'Artes']" appearance="outlined" />
                <x-form.input type="datetime" label="Dia e hora" name="datetime-outlined" appearance="outlined" />
                <x-form.input type="date" :value="now()" size="small" label="Dia" name="dia-outlined" appearance="outlined" />
                <x-form.input type="date" size="small" name="date-outlined" appearance="outlined" />
                <x-form.input type="textarea" size="full" label="Texto" name="textarea-outlined" appearance="outlined" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Display de Dados
            </summary>
            <div class="flex flex-col gap-5">
                <x-display-dado label="Nome" value="Gabriel mori" />
            </div>
        </details>
    </div>

    <div class="flex flex-col bg-black rounded-lg ring-2 ring-on-surface gap-5 p-5 text-white mb-5">
        <h2 class="text-headline-medium">Componentes Black</h2>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Form Inputs
            </summary>
            <div class="flex flex-col gap-5">
                <x-form.input label="Nome:" />
                <x-form.input type="password" label="Senha:" />
                <x-form.input type="password_forgot" label="Senha:" />
                <livewire:form.select :options="['Matemática', 'Português', 'Artes']" label="Disciplina:" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Botões
            </summary>
            <div class="flex flex-col gap-5">
                <x-button label="Size default" />
                <x-button label="Size dynamic" size="dynamic" />
                <x-button label="Size full" size="full" />
                <x-button label="Color secondary" color="secondary" />
                <x-button label="Color tertiary" color="tertiary" />
                <x-button label="Color yellow" color="yellow" />
                <x-button label="Color red" color="red" />
                <x-button label="IconPos left" color="secondary" icon="add" icon-pos="left" />
                <x-button label="IconPos right" color="secondary" icon="file_export" icon-pos="right" />
                <x-button icon="person_add" icon-color="white" />
                <x-button icon="person_remove" color="red" icon-color="white" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Auth Card
            </summary>
            <div class="flex items-start gap-5 mt-2">
                <x-auth-card title="Login" width="125">
                    <x-form.input label="Nome:" />
                    <x-form.input type="password_forgot" label="Senha:" />
                    <x-button label="Acessar" type="submit" size="full" />
                    <div class="flex flex-col w-full">
                        <p class="text-body-small">Não possui uma conta?</p>
                        <x-button label="Solicitar cadastro" type="link" href="#" size="full" />
                    </div>
                </x-auth-card>

                <x-auth-card title="Solicitar Cadastro" width="125">
                    <x-button label="Sou um professor de ensino regular" type="link" href="#" size="full" />
                    <x-button label="Sou um técnicos de educação especial" type="link" href="#" size="full" />
                    <x-button label="Sou um docente de educação especial" type="link" href="#" size="full" />
                    <div class="flex flex-col w-full">
                        <p class="text-body-small">Já possui uma conta?</p>
                        <x-button label="Fazer login" type="link" href="#" size="full" />
                    </div>
                </x-auth-card>
            </div>
        </details>
    </div>

</x-layouts.main>

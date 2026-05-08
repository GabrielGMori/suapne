<x-layouts.main title="Componentes">
    <h1>Componentes</h1>
    <hr class="mt-3 mb-5">

    <div class="flex flex-col bg-surface rounded-lg border border-black gap-5 p-5 mb-5">
        <h2 class="text-headline-medium">Componentes Surface</h2>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Form Inputs
            </summary>
            <div class="flex flex-col gap-5">
                <x-form-input type="text" label="Nome completo" appearance="outlined" />
                <x-form-input type="select" label="Componente curricular" :options="['Matemática', 'Português', 'Artes']" appearance="outlined" />
                <x-form-input type="select" size="tiny" value="20" :options="['20', '10', '5']" appearance="outlined" />
                <x-form-input type="multiselect" label="Componentes curriculares" :options="['Matemática', 'Português', 'Artes']" appearance="outlined" />
                <x-form-input type="datetime" label="Dia e hora" appearance="outlined" />
                <x-form-input type="date" size="small" label="Dia" appearance="outlined" />
                <x-form-input type="date" size="small" appearance="outlined" />
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
                <x-form-input type="text" label="Nome:" />
                <x-form-input type="password" label="Senha:" />
                <x-form-input type="password_forgot" label="Senha:" />
                <x-form-input type="select" :options="['Matemática', 'Português', 'Artes']" label="Disciplina:" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Botões
            </summary>
            <div class="flex flex-col gap-5">
                <x-button text="Size default" />
                <x-button text="Size dynamic" size="dynamic" />
                <x-button text="Size full" size="full" />
                <x-button text="Color secondary" color="secondary" />
                <x-button text="Color tertiary" color="tertiary" />
                <x-button text="Color yellow" color="yellow" />
                <x-button text="Color red" color="red" />
                <x-button text="IconPos left" color="secondary" icon="add" iconPos="left" />
                <x-button text="IconPos right" color="secondary" icon="file_export" iconPos="right" />
                <x-button icon="person_add" />
                <x-button icon="person_remove" color="red" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Auth Card
            </summary>
            <div class="flex items-start gap-5 mt-2">
                <x-auth-card title="Login" titleMargin="10" width="125">
                    <x-form-input type="text" label="Nome:" />
                    <x-form-input type="password_forgot" label="Senha:" />
                    <x-button text="Acessar" type="submit" size="full" />
                    <div class="flex flex-col w-full">
                        <p class="text-body-small">Não possui uma conta?</p>
                        <x-button text="Solicitar cadastro" type="link" href="#" size="full" />
                    </div>
                </x-auth-card>

                <x-auth-card title="Solicitar Cadastro" titleMargin="2" width="125">
                    <x-button text="Sou um professor de ensino regular" type="link" href="#" size="full" />
                    <x-button text="Sou um técnicos de educação especial" type="link" href="#" size="full" />
                    <x-button text="Sou um docente de educação especial" type="link" href="#" size="full" />
                    <div class="flex flex-col w-full">
                        <p class="text-body-small">Já possui uma conta?</p>
                        <x-button text="Fazer login" type="link" href="#" size="full" />
                    </div>
                </x-auth-card>
            </div>
        </details>
    </div>

    <div class="flex flex-col bg-white rounded-lg border border-surface gap-5 p-5 text-black mb-5">
        <h2 class="text-headline-medium">Componentes White</h2>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Form Inputs
            </summary>
            <div class="flex flex-col gap-5">
                <x-form-input type="select" :options="['Matemática', 'Português', 'Artes']" placeholder="Disciplina" appearance="surface" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Status
            </summary>
            <div class="flex flex-col gap-5 mt-2">
                <div class="flex gap-2">
                    <x-status text="Pendente" color="error" />
                    <x-status text="Aguardando" color="warn" />
                    <x-status text="Aprovado" color="success" />
                    <x-status text="Pré-visualização" color="info" />
                    <x-status text="Matriculado" color="dark" />
                </div>
                <div class="flex gap-2">
                    <x-status text="Pendente" color="error" :filled="true" />
                    <x-status text="Aguardando" color="warn" :filled="true" />
                    <x-status text="Aprovado" color="success" :filled="true" />
                    <x-status text="Pré-visualização" color="info" :filled="true" />
                    <x-status text="Matriculado" color="dark" :filled="true" />
                </div>
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Seção Expansível
            </summary>
            <div class="mt-2">
                <x-secao-expansivel title="Dados gerais">
                    <div class="flex gap-8">
                        <div class="shrink-0 flex items-start justify-center">
                            <div
                                class="w-32 h-32 bg-[#a9a9a9] rounded-full flex items-center justify-center text-[#f4f4f4] overflow-hidden">
                                <span class="material-symbols-outlined text-[100px] mt-6">person</span>
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

                </x-secao-expansivel>
            </div>
        </details>
    </div>
</x-layouts.main>

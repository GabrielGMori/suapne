<x-layouts.main title="Componentes">
    <div class="flex flex-col bg-white rounded-lg border border-surface gap-5 p-5 text-black mb-5">
        <h2 class="text-headline-medium">Componentes White</h2>
        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                List View
            </summary>
            <div class="flex flex-col gap-5">
                <x-list-view
                    title="Estudantes"
                    :items="App\Models\Estudante::paginate(10)"
                    :columns="[
                        ['label' => 'Nome do Estudante', 'key' => 'nome', 'size' => 'large'],
                        ['label' => 'Curso do Estudante', 'key' => 'curso', 'size' => 'large'],
                        ['label' => 'Período', 'key' => 'periodo', 'size' => 'small', 'format' => fn($value) => $value.'°'],
                        ['label' => 'Situação', 'key' => 'situacao',
                        'format' => function($value) {
                            $colors = [
                                'Matriculado' => 'success',
                                'Formado' => 'warning',
                                'Evadido' => 'danger',
                            ];
                            $color = $colors[$value] ?? 'dark';
                            return view('components.status', ['label' => $value, 'color' => $color])->render();
                        }],
                    ]"
                    create-url="#"
                    create-label="Novo Estudante"

                    :icon="fn($item) => match($item->curso) {
                        'Arquitetura' => $icon = 'architecture',
                        'Medicina' => $icon = 'medical_services',
                        'Engenharia' => $icon = 'engineering',
                        default => $icon = 'school',
                    }"
                    :image-icon="false"

                    :actions="[
                        ['url' => '/', 'method' => 'POST']
                    ]"
                    empty-message="Nenhum estudante foi encontrado"
                />
            </div>
        </details>

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
                    <x-status label="Pendente" color="error" />
                    <x-status label="Aguardando" color="warning" />
                    <x-status label="Aprovado" color="success" />
                    <x-status label="Pré-visualização" color="info" />
                    <x-status label="Matriculado" color="dark" />
                </div>
                <div class="flex gap-2">
                    <x-status label="Pendente" color="error" :filled="true" />
                    <x-status label="Aguardando" color="warning" :filled="true" />
                    <x-status label="Aprovado" color="success" :filled="true" />
                    <x-status label="Pré-visualização" color="info" :filled="true" />
                    <x-status label="Matriculado" color="dark" :filled="true" />
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

                </x-secao-expansivel>
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
                <x-form-input type="text" label="Nome completo" name="nome-outlined" appearance="outlined" />
                <x-form-input type="select" label="Componente curricular" name="componente-outlined" :options="['Matemática', 'Português', 'Artes']" appearance="outlined" placeholder="Selecionar" />
                <x-form-input type="select" size="tiny" value="20" name="number-outlined" :options="['20', '10', '5']" appearance="outlined" />
                <x-form-input type="multiselect" label="Componentes curriculares" name="componentes-outlined" :options="['Matemática', 'Português', 'Artes']" appearance="outlined" />
                <x-form-input type="datetime" label="Dia e hora" name="datetime-outlined" appearance="outlined" />
                <x-form-input type="date" size="small" label="Dia" name="dia-outlined" appearance="outlined" />
                <x-form-input type="date" size="small" name="date-outlined" appearance="outlined" />
                <x-form-input type="textarea" size="full" label="Texto" name="textarea-outlined" appearance="outlined" />
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
                <x-button label="Size default" />
                <x-button label="Size dynamic" size="dynamic" />
                <x-button label="Size full" size="full" />
                <x-button label="Color secondary" color="secondary" />
                <x-button label="Color tertiary" color="tertiary" />
                <x-button label="Color yellow" color="yellow" />
                <x-button label="Color red" color="red" />
                <x-button label="IconPos left" color="secondary" icon="add" icon-pos="left" />
                <x-button label="IconPos right" color="secondary" icon="file_export" icon-pos="right" />
                <x-button icon="person_add" />
                <x-button icon="person_remove" color="red" />
            </div>
        </details>

        <details class="group">
            <summary class="text-title-large mb-3 mt-5 cursor-pointer select-none outline-none">
                Auth Card
            </summary>
            <div class="flex items-start gap-5 mt-2">
                <x-auth-card title="Login" width="125">
                    <x-form-input type="text" label="Nome:" />
                    <x-form-input type="password_forgot" label="Senha:" />
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

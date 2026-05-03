@php
    $componentTypes = [
        [
            'key' => 'default',
            'title' => 'Text input',
            'description' => 'A standard single-line text input. Use it when you need a normal text field with optional label, placeholder and helper text.',
            'snippet' => "<x-default-input type=\"default\" label=\"Nome\" name=\"wiki_default\" placeholder=\"Digite seu nome\" helper=\"Campo obrigatório\" />",
        ],
        [
            'key' => 'password',
            'title' => 'Password',
            'description' => 'Password input with a show/hide toggle. The value is hidden by default and can be revealed interactively.',
            'snippet' => "<x-default-input type=\"password\" label=\"Senha\" name=\"wiki_password\" placeholder=\"Digite sua senha\" />",
        ],
        [
            'key' => 'password_forgot',
            'title' => 'Password forgot',
            'description' => 'A password field variant that includes a “forgot password” helper link when no helper text is provided.',
            'snippet' => "<x-default-input type=\"password_forgot\" label=\"Senha\" name=\"wiki_password_forgot\" />",
        ],
        [
            'key' => 'date',
            'title' => 'Date',
            'description' => 'Date picker input using the browser native date control.',
            'snippet' => "<x-default-input type=\"date\" label=\"Data\" name=\"wiki_date\" value=\"2026-05-02\" />",
        ],
        [
            'key' => 'datetime',
            'title' => 'Date & time',
            'description' => 'Date-time picker input using the browser native datetime-local control.',
            'snippet' => "<x-default-input type=\"datetime\" label=\"Data e hora\" name=\"wiki_datetime\" value=\"2026-05-02T10:30\" />",
        ],
        [
            'key' => 'dropdown',
            'title' => 'Dropdown select',
            'description' => 'A native select dropdown. Useful for single-choice selections from a list of options.',
            'snippet' => "<x-default-input type=\"dropdown\" label=\"Transporte\" name=\"wiki_dropdown\" :options=\"['car' => 'Carro', 'bike' => 'Bicicleta', 'truck' => 'Caminhão']\" value=\"bike\" />",
        ],
        [
            'key' => 'dropdown_small',
            'title' => 'Small dropdown',
            'description' => 'A compact dropdown select variant with smaller control height.',
            'snippet' => "<x-default-input type=\"dropdown_small\" label=\"Transporte\" name=\"wiki_dropdown_small\" :options=\"['car' => 'Carro', 'bike' => 'Bicicleta']\" />",
        ],
        [
            'key' => 'multiselect',
            'title' => 'Multi-select',
            'description' => 'A custom Alpine-powered multi-select control that allows selecting several options and renders hidden inputs for form submission.',
            'snippet' => "<x-default-input type=\"multiselect\" label=\"Seleções\" name=\"wiki_multiselect\" :options=\"['1' => 'Opção 1', '2' => 'Opção 2', '3' => 'Opção 3']\" :value=\"['1', '3']\" />",
        ],
        [
            'key' => 'textarea',
            'title' => 'Textarea',
            'description' => 'A multi-line text input for longer notes or descriptions.',
            'snippet' => "<x-default-input type=\"textarea\" label=\"Descrição\" name=\"wiki_textarea\" placeholder=\"Escreva uma observação\">",
        ],
        [
            'key' => 'file',
            'title' => 'File upload',
            'description' => 'A file input field for selecting and uploading files.',
            'snippet' => "<x-default-input type=\"file\" label=\"Anexo\" name=\"wiki_file\" />",
        ],
    ];
@endphp

<x-layouts.app title="Component Wiki">
    <div class="mx-auto flex w-full max-w-7xl flex-col gap-8 px-6 py-8 text-slate-950">
        <header class="space-y-3">
            <div class="inline-flex items-center gap-3 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                x-default-input component wiki
            </div>
            <div>
                <h1 class="text-3xl font-semibold">Interactive component reference</h1>
                <p class="max-w-3xl text-slate-600">Browse all supported `x-default-input` types, see live examples, and copy the usage snippets directly from the wiki.</p>
            </div>
        </header>

        <div x-data="{
            current: 'default',
            types: @js($componentTypes),
            get active() {
                return this.types.find((item) => item.key === this.current) || this.types[0];
            }
        }"
        x-cloak
        class="space-y-8"
        >
            <section class="grid gap-3 md:grid-cols-[280px_1fr]">
                <aside class="space-y-4 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Types</p>
                            <p class="mt-1 text-sm text-slate-600">Select a component type to preview and inspect its props.</p>
                        </div>
                    </div>

                    <div class="grid gap-2">
                        <template x-for="type in types" :key="type.key">
                            <button
                                type="button"
                                @click="current = type.key"
                                :class="current === type.key ? 'bg-slate-950 text-white shadow' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'"
                                class="w-full rounded-2xl px-4 py-3 text-left transition-colors duration-150"
                            >
                                <div class="flex items-center justify-between gap-3">
                                    <span class="font-semibold" x-text="type.title"></span>
                                    <span class="text-xs uppercase tracking-[0.2em] text-slate-500" x-text="type.key"></span>
                                </div>
                            </button>
                        </template>
                    </div>
                </aside>

                <article class="space-y-6 rounded-3xl border border-slate-200 bg-slate-50 p-6 shadow-sm">
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Live preview</p>
                                <h2 class="text-2xl font-semibold" x-text="active.title"></h2>
                            </div>
                            <div class="rounded-full bg-white px-3 py-1 text-sm font-medium text-slate-600 shadow-sm">type: <span x-text="active.key"></span></div>
                        </div>
                        <p class="max-w-3xl text-slate-600" x-text="active.description"></p>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-[1fr_400px]">
                        <section class="space-y-4 rounded-3xl border border-slate-200 bg-white p-5">
                            <div class="space-y-4">
                                <div class="rounded-3xl border border-slate-200 bg-slate-100 p-5">
                                    <div x-show="current === 'default'" class="space-y-4">
                                        <x-default-input type="default" label="Nome" name="wiki_default" placeholder="Digite seu nome" helper="Campo obrigatório" />
                                    </div>
                                    <div x-show="current === 'password'" class="space-y-4">
                                        <x-default-input type="password" label="Senha" name="wiki_password" placeholder="Digite sua senha" />
                                    </div>
                                    <div x-show="current === 'password_forgot'" class="space-y-4">
                                        <x-default-input type="password_forgot" label="Senha" name="wiki_password_forgot" />
                                    </div>
                                    <div x-show="current === 'date'" class="space-y-4">
                                        <x-default-input type="date" label="Data" name="wiki_date" value="2026-05-02" />
                                    </div>
                                    <div x-show="current === 'datetime'" class="space-y-4">
                                        <x-default-input type="datetime" label="Data e hora" name="wiki_datetime" value="2026-05-02T10:30" />
                                    </div>
                                    <div x-show="current === 'dropdown'" class="space-y-4">
                                        <x-default-input type="dropdown" label="Transporte" name="wiki_dropdown" :options="['car' => 'Carro', 'bike' => 'Bicicleta', 'truck' => 'Caminhão']" value="bike" />
                                    </div>
                                    <div x-show="current === 'dropdown_small'" class="space-y-4">
                                        <x-default-input type="dropdown_small" label="Transporte" name="wiki_dropdown_small" :options="['car' => 'Carro', 'bike' => 'Bicicleta']" />
                                    </div>
                                    <div x-show="current === 'multiselect'" class="space-y-4">
                                        <x-default-input type="multiselect" label="Seleções" name="wiki_multiselect" :options="['1' => 'Opção 1', '2' => 'Opção 2', '3' => 'Opção 3']" :value="['1', '3']" />
                                    </div>
                                    <div x-show="current === 'modal_select'" class="space-y-4">
                                        <x-default-input type="modal_select" label="Modal select" name="wiki_modal_select" value="Selecionar opção" />
                                        <p class="text-sm text-slate-500">This button dispatches <code class="rounded bg-slate-100 px-1 py-0.5">open-modal-select</code> when clicked.</p>
                                    </div>
                                    <div x-show="current === 'textarea'" class="space-y-4">
                                        <x-default-input type="textarea" label="Descrição" name="wiki_textarea" placeholder="Escreva uma observação" value="Exemplo de texto em várias linhas." />
                                    </div>
                                    <div x-show="current === 'file'" class="space-y-4">
                                        <x-default-input type="file" label="Anexo" name="wiki_file" />
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="space-y-4 rounded-3xl border border-slate-200 bg-white p-5">
                            <div>
                                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Usage</h3>
                                <pre class="mt-3 overflow-x-auto rounded-3xl bg-slate-950 p-4 text-sm text-white"><code x-text="active.snippet"></code></pre>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">When to use</h3>
                                <p class="mt-3 text-slate-600">The component supports both native input types and custom UI variations for dropdowns, multi-selects, and modal selects. Use the list on the left to review each type and copy example markup.</p>
                            </div>
                        </section>
                    </div>
                </article>
            </section>

            <section class="space-y-6">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-3">
                        <div>
                            <h2 class="text-xl font-semibold">Component props</h2>
                            <p class="text-sm text-slate-600">Supported props for `x-default-input` and how they change behavior.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-separate border-spacing-0 text-left text-sm">
                                <thead>
                                    <tr class="bg-slate-100 text-slate-700">
                                        <th class="border border-slate-200 px-4 py-3">Prop</th>
                                        <th class="border border-slate-200 px-4 py-3">Values</th>
                                        <th class="border border-slate-200 px-4 py-3">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">type</td>
                                        <td class="border border-slate-200 px-4 py-3">default, password, password_forgot, date, datetime, dropdown, dropdown_small, multiselect, modal_select, textarea, file</td>
                                        <td class="border border-slate-200 px-4 py-3">Controls the rendered input type and internal component behavior.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">appearance</td>
                                        <td class="border border-slate-200 px-4 py-3">default, outlined, soft</td>
                                        <td class="border border-slate-200 px-4 py-3">Changes the visual styling of the input control.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">size</td>
                                        <td class="border border-slate-200 px-4 py-3">tiny, small, medium, large</td>
                                        <td class="border border-slate-200 px-4 py-3">Adjusts the input height and padding.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">label</td>
                                        <td class="border border-slate-200 px-4 py-3">string</td>
                                        <td class="border border-slate-200 px-4 py-3">Text label rendered above the input.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">name</td>
                                        <td class="border border-slate-200 px-4 py-3">string</td>
                                        <td class="border border-slate-200 px-4 py-3">Form field name used for submission and old input repopulation.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">placeholder</td>
                                        <td class="border border-slate-200 px-4 py-3">string</td>
                                        <td class="border border-slate-200 px-4 py-3">Override default placeholder text for supported types.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">helper</td>
                                        <td class="border border-slate-200 px-4 py-3">string</td>
                                        <td class="border border-slate-200 px-4 py-3">Helper text rendered below the field.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">options</td>
                                        <td class="border border-slate-200 px-4 py-3">array</td>
                                        <td class="border border-slate-200 px-4 py-3">Required for dropdown, dropdown_small and multiselect variants.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-slate-50">
                                        <td class="border border-slate-200 px-4 py-3">multiple</td>
                                        <td class="border border-slate-200 px-4 py-3">boolean</td>
                                        <td class="border border-slate-200 px-4 py-3">Additional multi-select behavior for native <code>select</code> fields.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <section class="space-y-4">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold">All live variants</h2>
                            <p class="text-sm text-slate-600">A quick reference grid for every supported `x-default-input` variation.</p>
                        </div>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Default</p>
                            <x-default-input type="default" label="Nome" name="wiki_default_card" placeholder="Digite seu nome" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Password</p>
                            <x-default-input type="password" label="Senha" name="wiki_password_card" placeholder="Digite sua senha" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Password forgot</p>
                            <x-default-input type="password_forgot" label="Senha" name="wiki_password_forgot_card" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Date</p>
                            <x-default-input type="date" label="Data" name="wiki_date_card" value="2026-05-02" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Datetime</p>
                            <x-default-input type="datetime" label="Data e hora" name="wiki_datetime_card" value="2026-05-02T10:30" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Dropdown</p>
                            <x-default-input type="dropdown" label="Transporte" name="wiki_dropdown_card" :options="['car' => 'Carro', 'bike' => 'Bicicleta']" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Dropdown small</p>
                            <x-default-input type="dropdown_small" label="Transporte" name="wiki_dropdown_small_card" :options="['car' => 'Carro', 'bike' => 'Bicicleta']" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Multiselect</p>
                            <x-default-input type="multiselect" label="Seleções" name="wiki_multiselect_card" :options="['1' => 'Opção 1', '2' => 'Opção 2']" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Modal select</p>
                            <x-default-input type="modal_select" label="Modal select" name="wiki_modal_select_card" value="Selecionar opção" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">Textarea</p>
                            <x-default-input type="textarea" label="Descrição" name="wiki_textarea_card" placeholder="Escreva uma observação" />
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="mb-3 font-semibold">File</p>
                            <x-default-input type="file" label="Anexo" name="wiki_file_card" />
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>

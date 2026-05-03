<x-layouts.app>
    <div x-data="{
        theme: 'default',
        sbType: 'text',
        sbLabel: 'Label de Exemplo',
        sbPlaceholder: 'Digite algo...',
        sbHelper: '',
        sbSize: 'medium',
        sbValue: '',
        sbOptions: { '1': 'Opção A', '2': 'Opção B', '3': 'Opção C' }
    }"
    class="min-h-screen transition-colors duration-500 p-8"
    :class="{
        'bg-secondary-container text-white': theme === 'default',
        'bg-white text-black': theme === 'outlined',
        'bg-surface text-black': theme === 'surface'
    }">

        <div class="max-w-6xl mx-auto">
            <header class="mb-12 border-b border-on-surface pb-6">
                <h1 class="text-display-medium font-bold uppercase tracking-tight">Wiki de Componentes: Input</h1>
                <p class="text-body-large opacity-80 mt-2">Guia oficial de uso do componente <code>x-default-input</code>.</p>
            </header>

            <!-- # Appearances -->
            <section id="appearances" class="mb-16">
                <h2 class="text-title-large mb-4"># Appearances (Aparências)</h2>
                <p class="text-body-medium mb-6">
                    A propriedade <code>appearance</code> define o estilo visual base do input. Ela deve ser escolhida de acordo com o contexto do fundo (background) onde o formulário está inserido.
                </p>

                <div class="flex gap-4 mb-8 bg-black/10 p-4 rounded-lg inline-flex">
                    <button @click="theme = 'default'" class="px-6 py-2 rounded-md bg-white text-black font-bold hover:scale-105 transition">Default (Escuro)</button>
                    <button @click="theme = 'outlined'" class="px-6 py-2 rounded-md border border-black bg-white text-black font-bold hover:scale-105 transition">Outlined (Borda)</button>
                    <button @click="theme = 'surface'" class="px-6 py-2 rounded-md bg-on-surface text-black font-bold hover:scale-105 transition">Surface (Cinza)</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center border border-dashed border-on-surface p-8 rounded-xl">
                    <x-default-input name="demo_app" label="Exemplo de Visualização" x-bind:appearance="theme" placeholder="O tema muda com os botões acima" />
                    <div class="text-body-small italic">
                        * O tema atual é: <strong x-text="theme"></strong>. <br>
                        Use <code>appearance="outlined"</code> para fundos claros e <code>appearance="default"</code> para fundos escuros/containers.
                    </div>
                </div>
            </section>

            <!-- # Types -->
            <section id="types" class="mb-16">
                <h2 class="text-title-large mb-4"># Types (Tipos)</h2>
                <p class="text-body-medium mb-6">O atributo <code>type</code> define a funcionalidade do campo. Aceita tipos nativos do HTML e variações customizadas.</p>

                <div class="space-y-10">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <x-default-input type="text" label="Texto" name="t_text" x-bind:appearance="theme" />
                            <x-default-input type="password" label="Senha" name="t_pass" x-bind:appearance="theme" />
                            <x-default-input type="password_forgot" label="Senha com Esqueci" name="t_pass_f" x-bind:appearance="theme" />
                            <x-default-input type="select" label="Select" name="t_select" :options="['m' => 'Masculino', 'f' => 'Feminino']" x-bind:appearance="theme" />
                        </div>
                        <div class="space-y-4">
                            <x-default-input type="multiselect" label="Multi-Select" name="t_multi" :options="['lar' => 'Laravel', 'alp' => 'Alpine', 'tai' => 'Tailwind']" x-bind:appearance="theme" />
                            <x-default-input type="date" label="Data" name="t_date" x-bind:appearance="theme" />
                            <x-default-input type="textarea" label="Textarea" name="t_area" x-bind:appearance="theme" />
                        </div>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-secondary text-white rounded-lg">
                    <h3 class="text-label-large mb-2 text-primary-accent">O Atributo <code>options</code></h3>
                    <p class="text-body-small">
                        Para <code>select</code> e <code>multiselect</code>, passe um array associativo <code>['valor' => 'Rótulo']</code>.
                        O componente gerencia automaticamente a seleção e o estado do Alpine.js para os chips.
                    </p>
                </div>
            </section>

            <!-- # Sizes -->
            <section id="sizes" class="mb-16">
                <h2 class="text-title-large mb-4"># Sizes (Tamanhos)</h2>
                <p class="text-body-medium mb-4">Controla a largura fixa ou fluida do componente.</p>
                <div class="space-y-4 bg-black/5 p-6 rounded-lg">
                    <x-default-input size="tiny" label="Tiny (w-11)" name="s1" x-bind:appearance="theme" />
                    <x-default-input size="small" label="Small (w-40)" name="s2" x-bind:appearance="theme" />
                    <x-default-input size="medium" label="Medium (w-75) - Padrão" name="s3" x-bind:appearance="theme" />
                    <x-default-input size="large" label="Large (w-100)" name="s4" x-bind:appearance="theme" />
                    <x-default-input size="full" label="Full (w-full)" name="s5" x-bind:appearance="theme" />
                </div>
            </section>

            <!-- # Text Attributes -->
            <section id="attributes" class="mb-16">
                <h2 class="text-title-large mb-4"># Atributos de Texto</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <ul class="space-y-4">
                            <li><strong class="text-primary-accent">label:</strong> Título acima do campo.</li>
                            <li><strong class="text-primary-accent">name:</strong> Atributo <code>name</code> para o formulário (e <code>id</code>).</li>
                            <li><strong class="text-primary-accent">placeholder:</strong> Texto de instrução dentro do campo.</li>
                            <li><strong class="text-primary-accent">value:</strong> Valor inicial do campo.</li>
                            <li><strong class="text-primary-accent">helper:</strong> Texto de suporte/dica exibido abaixo do campo.</li>
                        </ul>
                    </div>
                    <div class="p-6 bg-black/20 rounded-lg border border-primary">
                        <x-default-input
                            label="Exemplo de Atributos"
                            name="exemplo_attr"
                            placeholder="Sou o placeholder"
                            value="Sou o valor"
                            helper="Sou o texto helper explicando algo."
                            x-bind:appearance="theme"
                        />
                    </div>
                </div>
            </section>

            <!-- # Summary Table -->
            <section id="summary" class="mb-16 overflow-hidden">
                <h2 class="text-title-large mb-4"># Resumo de Atributos</h2>
                <table class="w-full text-left border-collapse bg-white/5 rounded-lg">
                    <thead>
                        <tr class="border-b border-on-surface">
                            <th class="p-4 text-label-medium">Atributo</th>
                            <th class="p-4 text-label-medium">Padrão</th>
                            <th class="p-4 text-label-medium">Descrição</th>
                        </tr>
                    </thead>
                    <tbody class="text-body-small">
                        <tr class="border-b border-white/10">
                            <td class="p-4 font-mono text-primary-accent">type</td>
                            <td class="p-4">'text'</td>
                            <td class="p-4">text, password, select, multiselect, date, textarea...</td>
                        </tr>
                        <tr class="border-b border-white/10">
                            <td class="p-4 font-mono text-primary-accent">appearance</td>
                            <td class="p-4">'default'</td>
                            <td class="p-4">default, outlined, surface.</td>
                        </tr>
                        <tr class="border-b border-white/10">
                            <td class="p-4 font-mono text-primary-accent">size</td>
                            <td class="p-4">'medium'</td>
                            <td class="p-4">tiny, small, medium, large, full.</td>
                        </tr>
                        <tr class="border-b border-white/10">
                            <td class="p-4 font-mono text-primary-accent">options</td>
                            <td class="p-4">[]</td>
                            <td class="p-4">Array para Selects (Key => Label).</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <!-- # Sandbox Interativo -->
            <section id="sandbox" class="mb-32">
                <h2 class="text-title-large mb-6 text-tertiary"># Sandbox (Área de Testes)</h2>
                <div class="bg-black/30 p-8 rounded-2xl border-2 border-tertiary">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Controles -->
                        <div class="space-y-4">
                            <h3 class="text-label-large mb-4 uppercase">Configurações</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <x-default-input label="Mudar Label" name="sb_l" x-model="sbLabel" appearance="outlined" size="full" />
                                <x-default-input label="Mudar Placeholder" name="sb_p" x-model="sbPlaceholder" appearance="outlined" size="full" />
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div class="flex flex-col gap-1">
                                    <label class="text-label-small">Tipo de Input</label>
                                    <select x-model="sbType" class="h-11 rounded-lg px-2 bg-white text-black border">
                                        <option value="text">text</option>
                                        <option value="password">password</option>
                                        <option value="date">date</option>
                                        <option value="textarea">textarea</option>
                                        <option value="select">select</option>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-label-small">Tamanho</label>
                                    <select x-model="sbSize" class="h-11 rounded-lg px-2 bg-white text-black border">
                                        <option value="small">small</option>
                                        <option value="medium">medium</option>
                                        <option value="large">large</option>
                                        <option value="full">full</option>
                                    </select>
                                </div>
                            </div>
                            <x-default-input label="Texto Auxiliar (Helper)" name="sb_h" x-model="sbHelper" appearance="outlined" size="full" />
                        </div>

                        <!-- Resultado -->
                        <div class="flex flex-col justify-center items-center bg-white/5 p-8 rounded-xl border border-white/10">
                            <h3 class="text-label-small mb-8 opacity-50">PREVIEW EM TEMPO REAL</h3>

                            <x-default-input
                                x-bind:type="sbType"
                                x-bind:label="sbLabel"
                                x-bind:placeholder="sbPlaceholder"
                                x-bind:helper="sbHelper"
                                x-bind:size="sbSize"
                                x-bind:appearance="theme"
                                :options="['1' => 'Opção de Teste', '2' => 'Outra Opção']"
                                name="sandbox_input"
                            />

                            <div class="mt-12 w-full">
                                <p class="text-label-small mb-2">Código Gerado:</p>
                                <pre class="bg-black p-4 rounded text-success text-body-small overflow-x-auto"><code>&lt;x-default-input
    type="<span x-text="sbType"></span>"
    appearance="<span x-text="theme"></span>"
    size="<span x-text="sbSize"></span>"
    label="<span x-text="sbLabel"></span>"
    placeholder="<span x-text="sbPlaceholder"></span>"
    helper="<span x-text="sbHelper"></span>"
/&gt;</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>

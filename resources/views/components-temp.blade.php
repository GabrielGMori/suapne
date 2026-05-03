<x-layouts.app>
    <div class="flex gap-0 min-h-screen bg-surface">

        {{-- Sidebar Nav --}}
        <aside class="w-56 flex-shrink-0 border-r border-on-surface/20 sticky top-0 h-screen overflow-y-auto py-6">
            <p class="px-5 mb-2 text-label-small text-secondary-accent uppercase tracking-widest">Tipos</p>
            <nav class="flex flex-col">
                <a href="#text"        class="wiki-nav-link">Text</a>
                <a href="#password"    class="wiki-nav-link">Password</a>
                <a href="#select"      class="wiki-nav-link">Select</a>
                <a href="#multiselect" class="wiki-nav-link">Multiselect</a>
                <a href="#textarea"    class="wiki-nav-link">Textarea</a>
                <a href="#date"        class="wiki-nav-link">Date</a>
                <a href="#datetime"    class="wiki-nav-link">Datetime</a>
                <a href="#file"        class="wiki-nav-link">File</a>
            </nav>
            <p class="px-5 mt-6 mb-2 text-label-small text-secondary-accent uppercase tracking-widest">Modificadores</p>
            <nav class="flex flex-col">
                <a href="#sizes"      class="wiki-nav-link">Sizes</a>
                <a href="#appearance" class="wiki-nav-link">Appearance</a>
                <a href="#all-props"  class="wiki-nav-link">All props</a>
            </nav>
        </aside>

        {{-- Content --}}
        <main class="flex-1 px-10 py-8 max-w-4xl">

            <h1 class="text-heading-large mb-1">Form Control</h1>
            <p class="text-body-medium text-secondary mb-10">
                Componente unificado para todos os campos de formulário do sistema.
                Usage: <code class="wiki-code">&lt;x-default-input type="..." name="..." /&gt;</code>
            </p>

            {{-- ================================================================ --}}
            {{-- TEXT --}}
            {{-- ================================================================ --}}
            <section id="text" class="wiki-section">
                <h2 class="wiki-section-title">Text</h2>
                <p class="wiki-section-desc">Tipo padrão. Aceita qualquer valor string.</p>

                <div class="wiki-preview">
                    <x-default-input type="text" name="demo_text_1" label="Sem valor" />
                    <x-default-input type="text" name="demo_text_2" label="Com valor" value="João Silva" />
                    <x-default-input type="text" name="demo_text_3" label="Com placeholder" placeholder="Digite seu nome completo" />
                    <x-default-input type="text" name="demo_text_4" label="Com helper" helper="Este campo é obrigatório" />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="text" name="nome" label="Nome" /&gt;

&lt;x-default-input type="text" name="nome" label="Nome"
    value="João Silva" /&gt;

&lt;x-default-input type="text" name="nome"
    placeholder="Digite seu nome completo" /&gt;

&lt;x-default-input type="text" name="nome"
    label="Nome" helper="Este campo é obrigatório" /&gt;</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- PASSWORD --}}
            {{-- ================================================================ --}}
            <section id="password" class="wiki-section">
                <h2 class="wiki-section-title">Password</h2>
                <p class="wiki-section-desc">
                    Dois variantes: <code class="wiki-code">password</code> e <code class="wiki-code">password_forgot</code>.
                    O variante forgot adiciona o link de redefinição automaticamente.
                </p>

                <div class="wiki-preview">
                    <x-default-input type="password" name="demo_pw_1" label="password" />
                    <x-default-input type="password_forgot" name="demo_pw_2" label="password_forgot" />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="password" name="senha" label="Senha" /&gt;

&lt;x-default-input type="password_forgot" name="senha" label="Senha" /&gt;</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- SELECT --}}
            {{-- ================================================================ --}}
            <section id="select" class="wiki-section">
                <h2 class="wiki-section-title">Select</h2>
                <p class="wiki-section-desc">
                    Dropdown com caret customizado. Passe as opções como array associativo
                    <code class="wiki-code">value => label</code>.
                    A seleção é restaurada via <code class="wiki-code">old()</code> automaticamente.
                </p>

                <div class="wiki-preview">
                    <x-default-input
                        type="select"
                        name="demo_select_1"
                        label="Sem valor selecionado"
                        :options="['ti' => 'Técnico em Informática', 'adm' => 'Administração', 'log' => 'Logística']"
                    />
                    <x-default-input
                        type="select"
                        name="demo_select_2"
                        label="Com valor pré-selecionado"
                        value="adm"
                        :options="['ti' => 'Técnico em Informática', 'adm' => 'Administração', 'log' => 'Logística']"
                    />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="select" name="curso" label="Curso"
    :options="['ti' => 'Técnico em Informática', 'adm' => 'Administração']" /&gt;

&lt;!-- Restaurar valor selecionado após falha de validação --&gt;
&lt;x-default-input type="select" name="curso" label="Curso"
    value="{{ old('curso', 0) }}"
    :options="$cursos" /&gt;</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- MULTISELECT --}}
            {{-- ================================================================ --}}
            <section id="multiselect" class="wiki-section">
                <h2 class="wiki-section-title">Multiselect</h2>
                <p class="wiki-section-desc">
                    Dropdown customizado com Alpine.js para múltiplas seleções.
                    Submete como <code class="wiki-code">name[]</code>.
                    Use <code class="wiki-code">nullable</code> na validação — o campo fica ausente quando nada é selecionado.
                </p>

                <div class="wiki-preview">
                    <x-default-input
                        type="multiselect"
                        name="demo_multi_1"
                        label="Sem seleção"
                        :options="['mat' => 'Matemática', 'geo' => 'Geografia', 'fis' => 'Física', 'qui' => 'Química']"
                    />
                    <x-default-input
                        type="multiselect"
                        name="demo_multi_2"
                        label="Com valores pré-selecionados"
                        :value="['mat', 'fis']"
                        :options="['mat' => 'Matemática', 'geo' => 'Geografia', 'fis' => 'Física', 'qui' => 'Química']"
                    />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="multiselect" name="disciplinas" label="Disciplinas"
    :options="$disciplinas" /&gt;

&lt;!-- Com valores pré-selecionados --&gt;
&lt;x-default-input type="multiselect" name="disciplinas"
    :value="$professor-&gt;disciplinas-&gt;pluck('id')"
    :options="$disciplinas" /&gt;

&lt;!-- Regras de validação --&gt;
'disciplinas'   =&gt; ['nullable', 'array'],
'disciplinas.*' =&gt; ['integer', 'exists:disciplinas,id'],</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- TEXTAREA --}}
            {{-- ================================================================ --}}
            <section id="textarea" class="wiki-section">
                <h2 class="wiki-section-title">Textarea</h2>
                <p class="wiki-section-desc">Campo de texto multilinha. Altura mínima de 9rem.</p>

                <div class="wiki-preview">
                    <x-default-input type="textarea" name="demo_ta_1" label="Vazio" />
                    <x-default-input type="textarea" name="demo_ta_2" label="Com valor"
                        value="O aluno demonstrou dificuldades em atividades em grupo." />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="textarea" name="necessidades" label="Necessidades"
    placeholder="Descreva as necessidades do estudante" /&gt;

&lt;x-default-input type="textarea" name="observacoes" /&gt;</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- DATE --}}
            {{-- ================================================================ --}}
            <section id="date" class="wiki-section">
                <h2 class="wiki-section-title">Date</h2>
                <p class="wiki-section-desc">
                    Renderiza um <code class="wiki-code">type="date"</code> nativo.
                    O value deve estar no formato <code class="wiki-code">Y-m-d</code>.
                </p>

                <div class="wiki-preview">
                    <x-default-input type="date" name="demo_date_1" label="Vazio" />
                    <x-default-input type="date" name="demo_date_2" label="Com valor" value="2008-01-01" />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="date" name="data_nascimento" label="Data de nascimento" /&gt;

&lt;!-- O Carbon formata automaticamente para Y-m-d --&gt;
&lt;x-default-input type="date" name="data_nascimento" /&gt;</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- DATETIME --}}
            {{-- ================================================================ --}}
            <section id="datetime" class="wiki-section">
                <h2 class="wiki-section-title">Datetime</h2>
                <p class="wiki-section-desc">
                    Renderiza <code class="wiki-code">type="datetime-local"</code>.
                    O value deve estar no formato <code class="wiki-code">Y-m-d\TH:i</code>.
                </p>

                <div class="wiki-preview">
                    <x-default-input type="datetime" name="demo_dt_1" label="Vazio" />
                    <x-default-input type="datetime" name="demo_dt_2" label="Com valor" value="2026-03-30T15:30" />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="datetime" name="dia_hora" label="Dia/Hora" /&gt;

&lt;x-default-input type="datetime" name="dia_hora" /&gt;</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- FILE --}}
            {{-- ================================================================ --}}
            <section id="file" class="wiki-section">
                <h2 class="wiki-section-title">File</h2>
                <p class="wiki-section-desc">
                    Upload de arquivo. Lembre-se de adicionar
                    <code class="wiki-code">enctype="multipart/form-data"</code> no seu form.
                </p>

                <div class="wiki-preview">
                    <x-default-input type="file" name="demo_file_1" label="Laudo" />
                </div>

                <pre class="wiki-code-block">&lt;form method="POST" enctype="multipart/form-data"&gt;
    &lt;x-default-input type="file" name="laudo" label="Laudo" /&gt;
&lt;/form&gt;

&lt;!-- Validação --&gt;
'laudo' =&gt; ['required', 'file', 'mimes:pdf', 'max:10240'],</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- SIZES --}}
            {{-- ================================================================ --}}
            <section id="sizes" class="wiki-section">
                <h2 class="wiki-section-title">Sizes</h2>
                <p class="wiki-section-desc">
                    Controlado pela prop <code class="wiki-code">size</code>. Aplica-se a todos os tipos.
                    O padrão é <code class="wiki-code">medium</code>.
                </p>

                <div class="wiki-preview flex-col items-start">
                    <x-default-input type="text" name="demo_size_tiny"   size="tiny"   placeholder="tiny" />
                    <x-default-input type="text" name="demo_size_small"  size="small"  placeholder="small" />
                    <x-default-input type="text" name="demo_size_medium" size="medium" placeholder="medium (padrão)" />
                    <x-default-input type="text" name="demo_size_large"  size="large"  placeholder="large" />
                    <x-default-input type="text" name="demo_size_full"   size="full"   placeholder="full" />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="text" name="x" size="tiny" /&gt;
&lt;x-default-input type="text" name="x" size="small" /&gt;
&lt;x-default-input type="text" name="x" /&gt;             &lt;!-- padrão: medium --&gt;
&lt;x-default-input type="text" name="x" size="large" /&gt;
&lt;x-default-input type="text" name="x" size="full" /&gt;</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- APPEARANCE --}}
            {{-- ================================================================ --}}
            <section id="appearance" class="wiki-section">
                <h2 class="wiki-section-title">Appearance</h2>
                <p class="wiki-section-desc">
                    Três variantes visuais. O padrão é <code class="wiki-code">default</code>.
                    O label muda de cor automaticamente com a aparência.
                </p>

                <div class="wiki-preview">
                    <x-default-input type="text" name="demo_app_1" label="default"   appearance="default"  placeholder="Aparência padrão" />
                    <x-default-input type="text" name="demo_app_2" label="outlined"  appearance="outlined"  placeholder="Com borda" />
                    <x-default-input type="text" name="demo_app_3" label="surface"   appearance="surface"   placeholder="Fundo surface" />
                </div>

                <pre class="wiki-code-block">&lt;x-default-input type="text" name="x" /&gt;
&lt;x-default-input type="text" name="x" appearance="outlined" /&gt;
&lt;x-default-input type="text" name="x" appearance="surface" /&gt;</pre>
            </section>

            {{-- ================================================================ --}}
            {{-- ALL PROPS --}}
            {{-- ================================================================ --}}
            <section id="all-props" class="wiki-section">
                <h2 class="wiki-section-title">All props</h2>

                <div class="overflow-x-auto">
                    <table class="wiki-table">
                        <thead>
                            <tr>
                                <th>Prop</th>
                                <th>Tipo</th>
                                <th>Padrão</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code class="wiki-code">type</code></td>
                                <td class="text-secondary">string</td>
                                <td><code class="wiki-code">'text'</code></td>
                                <td class="text-secondary">text, password, password_forgot, select, multiselect, textarea, file, date, datetime</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">name</code></td>
                                <td class="text-secondary">string</td>
                                <td><code class="wiki-code">''</code></td>
                                <td class="text-secondary">Atributo HTML name. Usado também como id.</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">label</code></td>
                                <td class="text-secondary">string|null</td>
                                <td><code class="wiki-code">null</code></td>
                                <td class="text-secondary">Renderiza um label acima do campo. Omitido se null.</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">value</code></td>
                                <td class="text-secondary">mixed</td>
                                <td><code class="wiki-code">''</code></td>
                                <td class="text-secondary">Valor inicial. Substituído por old() em falha de validação.</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">placeholder</code></td>
                                <td class="text-secondary">string</td>
                                <td><code class="wiki-code">''</code></td>
                                <td class="text-secondary">Sobrescreve o placeholder resolvido automaticamente.</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">size</code></td>
                                <td class="text-secondary">string</td>
                                <td><code class="wiki-code">'medium'</code></td>
                                <td class="text-secondary">tiny, small, medium, large, full</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">appearance</code></td>
                                <td class="text-secondary">string</td>
                                <td><code class="wiki-code">'default'</code></td>
                                <td class="text-secondary">default, outlined, surface</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">options</code></td>
                                <td class="text-secondary">array</td>
                                <td><code class="wiki-code">[]</code></td>
                                <td class="text-secondary">Array associativo [value => label] para select e multiselect.</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">multiple</code></td>
                                <td class="text-secondary">bool</td>
                                <td><code class="wiki-code">false</code></td>
                                <td class="text-secondary">Habilita multiple nativo no select.</td>
                            </tr>
                            <tr>
                                <td><code class="wiki-code">helper</code></td>
                                <td class="text-secondary">string</td>
                                <td><code class="wiki-code">''</code></td>
                                <td class="text-secondary">Texto auxiliar exibido abaixo do campo.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </div>

    @push('styles')
    <style>
        .wiki-nav-link {
            @apply px-5 py-1.5 text-body-medium text-secondary hover:text-primary hover:bg-surface transition-colors duration-100 border-l-2 border-transparent;
        }
        .wiki-nav-link.active {
            @apply text-primary border-l-primary bg-surface;
        }
        .wiki-section {
            @apply mb-14;
        }
        .wiki-section-title {
            @apply text-heading-medium mb-1 pb-3 border-b border-on-surface/20;
        }
        .wiki-section-desc {
            @apply text-body-medium text-secondary mt-2 mb-5;
        }
        .wiki-preview {
            @apply flex flex-wrap gap-6 items-end bg-surface rounded-xl p-6 mb-4;
        }
        .wiki-code {
            @apply font-mono text-label-small bg-surface px-1.5 py-0.5 rounded;
        }
        .wiki-code-block {
            @apply font-mono text-label-small bg-surface rounded-xl p-5 overflow-x-auto whitespace-pre text-secondary;
        }
        .wiki-table {
            @apply w-full text-body-medium border-collapse;
        }
        .wiki-table th {
            @apply text-left text-label-small text-secondary-accent uppercase tracking-wider pb-2 border-b border-on-surface/20 px-3;
        }
        .wiki-table td {
            @apply py-3 px-3 border-b border-on-surface/10 align-top;
        }
        .wiki-table tr:last-child td {
            @apply border-b-0;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        const links = document.querySelectorAll('.wiki-nav-link');
        const sections = document.querySelectorAll('.wiki-section');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    links.forEach(l => l.classList.remove('active'));
                    const active = document.querySelector(`.wiki-nav-link[href="#${entry.target.id}"]`);
                    if (active) active.classList.add('active');
                }
            });
        }, { rootMargin: '-30% 0px -60% 0px' });

        sections.forEach(s => observer.observe(s));
    </script>
    @endpush
</x-layouts.app>

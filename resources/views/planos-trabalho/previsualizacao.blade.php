<x-layouts.main title="PTE Ricardo Borges -Matematica III -2026">
    <div>

        <h2 class="flex items-center gap-5 mb-5 text-display-small">Adaptação e/ou flexibilização curricular</h2>
            <x-status label="Pré-visualização" :filled="false"/>

            <h4>Período de realização: 08/02/2026 a 29/11/2026</h4>

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">1. Dados do estudante</h2>
                <p>Nome: Ricardo Borges</p>
                <p>Curso/Turma: Informática 4</p>
                <p>Série/Ano: 4</p>
                <p>Componente curricular: Matemática III</p>
                <p>Docente: José Muda</p>
                <p>Carga horária de atendimento individualizado (se necessário): ---</p>
                <p>Dia/Horário/Local: 30/03/2026 15:30 CNAPNE</p>

                <p>Necessidade educacional específica:</p>
                <x-form.input disabled type="textarea" name="adaptacaopedagogica_outlined" appearance="outlined"
                                     size="full" class="bg-surface" value="O aluno possui..."/>
            </div>

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">2. Particularidades do estudante</h2>
                <x-form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                     appearance="outlined" size="full" class="bg-surface"
                                     value="Atendimentos e recursos utilizados pelo estudante..."/>
            </div>
            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">3. Conteúdos do componente curricular que necessitam de adaptação e/ou
                    flexibilização:
                    <x-form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                         appearance="outlined" size="full" class="bg-surface"
                                         value="Ementa da disciplina preenchida automaticamente..."/>
                </h2>
            </div>


            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">4. Objetivos específicos para o estudante neste período
                    <x-form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                         appearance="outlined" size="full" class="bg-surface"
                                         value="Preenchido pelo professor"/>
                </h2>
            </div>

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">4. Objetivos específicos para o estudante neste período
                    <x-form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                         appearance="outlined" size="full" class="bg-surface"
                                         value="Preenchido pelo professor"/>
                </h2>
            </div>

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">5. Instrumentos avaliativos pretendidos e procedimentos adotados:</h2>
                <p>(De acordo com a especificidade do componente. Consultar o Art. 9 da Res. 50/2017)</p>
                <x-form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                     appearance="outlined" size="full" class="bg-surface"
                                     value="Preenchido pelo professor"/>
            </div>

            <div class="flex flex-col bg-surface rounded-lg gap-5 mb-5 p-5">
                <h2 class="text-display-small">6. Outras considerações relevantes:</h2>

                <x-form.input disabled type="textarea" name="atendimentomultiprofissional_outlined"
                                     appearance="outlined" size="full" class="bg-surface"
                                     value="Preenchido pelo professor"/>
            </div>

            <div class="flex justify-end gap-2">
                <x-button.cancel label="Voltar" color="tertiary" fallback="planos-trabalho.create" />
            </div>
    </div>
</x-layouts.main>

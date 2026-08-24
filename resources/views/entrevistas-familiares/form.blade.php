<x-layouts.main title="Entrevista Escolar Familiar">
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">1. Identificação do Estudante</h2>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="date" label="Data da entrevista" appearance="outlined" size="small"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="text" label="Nome completo do estudante" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Nome social" appearance="outlined" size="small"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="number" label="Idade" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="date" label="Data da entrevista" appearance="outlined" size="small"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="text" label="Nome completo da mãe" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Nome completo do pai" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Nome completo da responsável" appearance="outlined"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="tel" label="Celular do estudante" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="tel" label="Celular da mãe" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="tel" label="Celular do pai" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="tel" label="Celular fixo" appearance="outlined" size="small"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="email" label="Email do estudante" appearance="outlined"/>
        <livewire:form.input disabled type="email" label="Email da mãe" appearance="outlined"/>
        <livewire:form.input disabled type="email" label="Email do pai" appearance="outlined"/>
        <livewire:form.input disabled type="email" label="Email do responsável" appearance="outlined"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="select" label="Pode ser chamado SAMU?" placeholder="Selecionar" appearance="outlined"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">2. Identificação do curso</h2>
        <livewire:form.input disabled type="text" label="Nome do curso" appearance="outlined"/>
        <livewire:form.input disabled type="select" label="Forma de oferta" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="number" label="Matricula" appearance="outlined"/>
        <livewire:form.input disabled type="select" label="Turno" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="number" label="Ano/Período" appearance="outlined" size="small"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">3. Cota de Ingresso</h2>
        <livewire:form.input disabled type="select" label="Cota" placeholder="Selecionar" appearance="outlined" size="small"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">4. Informações Familiares</h2>
        <livewire:form.input disabled type="text" label="Formação da mãe" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Profissão da mãe" appearance="outlined"/>
        <livewire:form.input disabled type="number" label="Idade da mãe" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="text" label="A mãe está atualmente empregada?" appearance="outlined"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="text" label="Formação do pai" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Profissão do pai" appearance="outlined"/>
        <livewire:form.input disabled type="number" label="Idade do pai" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="text" label="O pai está atualmente empregado?" appearance="outlined"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="text" label="Formação do responsável" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Profissão do responsável" appearance="outlined"/>
        <livewire:form.input disabled type="number" label="Idade do responsável" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="text" label="O responsável está atualmente empregado?" appearance="outlined"/>
        <hr class="text-on-surface">
        <livewire:form.input disabled type="text" label="Número de irmãos" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Estudante mora com" appearance="outlined"/>
        <livewire:form.input disabled type="select" label="Pais separados?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Alguma pessoa da família tem deficiência?" placeholder="Selecionar" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Se sim, qual?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Rotina diária antes e depois das aulas/atividades domésticas" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Relacionamento com familiares" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Com quem mais convive fora da escola?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Mantém amizades com pessoas da mesma idade" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="A família se reúne para atividades de lazer? Que tipo?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Condições de moradia (casa própria, alugada, outro)" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Tem ambiente específico para estudo? Como é?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Há acompanhamento sobre o que acessa no computador? Ou sobre interações no celular?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Qual é o local da casa onde o estudante permanece mais tempo?" appearance="outlined"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">5. História Escolar do Estudante</h2>
        <livewire:form.input disabled type="text" label="Qual a escola de origem?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Há quanto tempo no IFPR?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Já reprovou algum ano escolar? Qual? Motivo?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Áreas de conhecimento com as quais têm mais facilidade na escola" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Áreas de conhecimento com as quais têm mais dificuldade na escola" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Trajetória escolar quanto a rendimentos, relacionamentos, adaptações, principais dificuldades e o que mais gostava (Antecedentes relevantes)" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Frequentou educação infantil a partir de que idade?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Com quantos anos aprendeu a ler e escrever?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Quais os cursos extra-escolares que já fez?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Foi necessária alguma Adaptação Curricular? Qual(is)?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Outras necessidades relatadas e/ou percebidas:" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Potencialidades do estudante. Em quais atividades se destaca? Na escola ou fora dela." appearance="outlined"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">6. Desenvolvimento biopsicosocial</h2>
        <livewire:form.input disabled type="text" label="Gestação planejada/desejada" appearance="outlined"/>
        <livewire:form.input disabled type="select" label="Fez pré-natal" placeholder="Selecionar" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Doenças apresentadas" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Usou fraldas até que idade?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Até que idade fez uso de mamadeira, chupeta, outros recursos de segurança afetiva?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="As indicações de vacinação foram cumpridas? Se não, por quê?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Faz uso de medicamento" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Seletividade ou restrição alimentar" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Internamentos e cirurgias" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Fez ou faz algum acompanhamento com profissional de Saúde externo?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Nome do fisioterapeuta" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Contato do fisioterapeuta" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Nome do fonoaudiólogo" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Contato do fonoaudiólogo" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Nome do psicólogo" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Contato do psicólogo" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Nome do neurologista" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Contato do neurologista" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Observações" appearance="outlined"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">7. Características de comportamento do Estudante</h2>
        <livewire:form.input disabled type="select" label="Timido?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Extrovertido?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Persistente?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Calmo?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Agitado?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Ansioso?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Organizado?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Perfeccionista?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Responsável?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Amoroso?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Nervoso?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="select" label="Inseguro?" placeholder="Selecionar" appearance="outlined" size="small"/>
        <livewire:form.input disabled type="text" label="Outros" appearance="outlined"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">8. Informações Gerais e de âmbito escolar</h2>
        <livewire:form.input disabled type="text" label="Origem e histórico do caso e dos atendimentos" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Faz uso de algum artefato para mobilidade? Qual(is)?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Há necessidade de adaptação de mobiliário? (carteira, rampas, apoio para pés, etc.)" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="É totalmente dependente para a locação na rampa, banheiros, sala de aula, laboratórios? Qual a necessidade?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Necessita de alguma adaptação para a utilização do computador? Qual?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Possui transporte para locomoção ao Campus? Necessita de auxílio para ingresso ao Campus?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Foi necessária alguma Adaptação Curricular? Qual(is)?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Sistema linguístico utilizado pelo estudante(Oral, gestual, LIBRAS, outros)" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Recursos ou equipamentos de acessibilidade já usados pelo estudante:" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Recursos ou equipamentos que necessitam ser providenciados:" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Outras necessidades relatadas e/ou percebidas:" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Sugestões para melhoria da adaptação" appearance="outlined"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Caso haja contato com a escola anterior</h2>
        <livewire:form.input disabled type="text" label="Teve acompanhamento de AEE? Fez uso da sala de recurso?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Potencialidades e dificuldades acadêmicas" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Tinha material adaptado? Quais?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Participou de apoio escolar? Qual?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Algum comportamento diferenciado?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Alguma questão de sensibilidade?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Algum momento de crise? Que tipo?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Teve laudo por encaminhamento da escola?" appearance="outlined"/>
    </div>
    <div class="flex flex-col bg-surface rounded-lg gap-5 p-5 mb-5">
        <h2 class="text-display-small">Caso haja contato com profissionais externos</h2>
        <livewire:form.input disabled type="text" label="Quando começou o tratamento?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Por que começou?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Apresenta crises de comportamento?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Qual ou quais situações desencadeiam crises?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Orientações para evitar estresse" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Quais as melhorias?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Maiores orientações para sala de aula e escola" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Necessita de abafador de som no ambiente escolar?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Como o estudante se organiza? Utiliza agendas para registrar seus compromissos?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Como o estudante aprende?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Quais recursos e/ou estratégias facilitam sua aprendizagem?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Quais recursos e/ou estratégias dificultam sua aprendizagem?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Em que área do conhecimento apresenta mais facilidade para aprender? Por quê?" appearance="outlined"/>
        <livewire:form.input disabled type="text" label="Em que área do conhecimento percebe mais dificuldade para aprender? Por quê?" appearance="outlined"/>
    </div>
    <div class="flex justify-end gap-2">
        <x-button label="Registrar"/>
    </div>
</x-layouts.main>

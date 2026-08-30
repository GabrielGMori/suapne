@props(['entrevistaFamiliar' => null])

<?php
use App\Models\Estudante;

?>

<x-layouts.pdf>
    <p class="text-center mb-lg"><b>ENTREVISTA ESCOLAR</b></p>

    <table class="table">
        <tr>
            <td><b>Data:</b> {{ $entrevistaFamiliar?->data?->format('d/m/Y') }}</td>
            <td><b>Responsável pelo preenchimento:</b> {{ $entrevistaFamiliar?->user->nome ?? '----' }}</td>
        </tr>
    </table>

    <p><b>1. Identificação do Estudante</b></p>
    <table class="table">
        <tr>
            <td style="width: 30%"><b>Nome completo</b></td>
            <td colspan="2">{{ $entrevistaFamiliar?->campos['nomeCompleto'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Nome social</b></td>
            <td colspan="2">{{ $entrevistaFamiliar?->campos['nomeSocial'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Idade</b></td>
            <td colspan="2">{{ $entrevistaFamiliar?->campos['idade'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Data de Nascimento</b></td>
            <td colspan="2">{{ $entrevistaFamiliar?->campos['dataNascimento'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Mãe</b></td>
            <td colspan="2">{{ $entrevistaFamiliar?->campos['nomeMae'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Pai</b></td>
            <td colspan="2">{{ $entrevistaFamiliar?->campos['nomePai'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Responsável</b></td>
            <td colspan="2">{{ $entrevistaFamiliar?->campos['nomeResponsavel'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Contatos</b></td>
            <td>
                Celular:<br>
                Estudante: {{ $entrevistaFamiliar?->campos['celularEstudante'] ?? '' }}<br>
                Mãe: {{ $entrevistaFamiliar?->campos['celularMae'] ?? '' }}<br>
                Pai: {{ $entrevistaFamiliar?->campos['celularPai'] ?? '' }}<br>
                Fixo: {{ $entrevistaFamiliar?->campos['celularFixo'] ?? '' }}
            </td>
            <td>
                E-mail:<br>
                Estudante: {{ $entrevistaFamiliar?->campos['emailEstudante'] ?? '' }}<br>
                Mãe: {{ $entrevistaFamiliar?->campos['emailMae'] ?? '' }}<br>
                Pai: {{ $entrevistaFamiliar?->campos['emailPai'] ?? '' }}<br>
                Responsável: {{ $entrevistaFamiliar?->campos['emailResponsavel'] ?? '' }}
            </td>
        </tr>
        <tr>
            <td><b>Em emergência pode ser chamado SAMU</b></td>
            <td colspan="2">
                SIM ( {{ $entrevistaFamiliar?->campos['podeSerChamadoSAMU'] == 'Sim' ? 'X' : ' ' }} )
                NÃO ( {{ $entrevistaFamiliar?->campos['podeSerChamadoSAMU'] == 'Não' ? 'X' : ' ' }} )
            </td>
        </tr>
    </table>

    <p><b>2. Identificação do curso</b></p>
    <table class="table">
        <tr>
            <td><b>Curso</b></td>
            <td>{{ $entrevistaFamiliar?->campos['nomeCurso'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Forma de Oferta:</b></td>
            <td>
                FIC ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'FIC' ? 'X' : ' ' }} )
                Proeja ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'Proeja' ? 'X' : ' ' }} )
                Integrado ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'Integrado' ? 'X' : ' ' }} )
                Subsequente ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'Subsequente' ? 'X' : ' ' }} )<br>
                Graduação - licenciatura ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'Graduação - Licenciatura' ? 'X' : ' ' }} )
                Graduação - bacharelado ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'Graduação - Bacharelado' ? 'X' : ' ' }} )
                Graduação - tecnólogo ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'Graduação - Tecnólogo' ? 'X' : ' ' }} ) <br>
                Especialização ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'Especialização' ? 'X' : ' ' }} )
                Mestrado ( {{ ($entrevistaFamiliar?->campos['formaOferta'] ?? '') == 'Mestrado' ? 'X' : ' ' }} )
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding:0;">
                <table style="width: 100%; border:none; border-collapse:collapse;">
                    <tr>
                        <td><b>Matrícula</b></td>
                        <td>{{ $entrevistaFamiliar?->campos['matricula'] ?? '' }}</td>
                        <td><b>Turno</b></td>
                        <td>{{ $entrevistaFamiliar?->campos['turno'] ?? '' }}</td>
                        <td><b>Ano/Período</b></td>
                        <td>{{ $entrevistaFamiliar?->campos['anoPeriodo'] ?? '' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p><b>3. Cota de Ingresso</b></p>
    <table class="table">
        <tr>
            <td><b>PNE</b></td>
            <td>( {{ $entrevistaFamiliar?->campos['cota'] == 'PNE' ? 'X' : ' ' }} )</td>
            <td><b>Social</b></td>
            <td>( {{ $entrevistaFamiliar?->campos['cota'] == 'Social' ? 'X' : ' ' }} )</td>
        </tr>
        <tr>
            <td><b>Pretos ou Pardos</b></td>
            <td>( {{ $entrevistaFamiliar?->campos['cota'] == 'Pretos ou Pardos' ? 'X' : ' ' }} )</td>
            <td><b>Escola Pública</b></td>
            <td>( {{ $entrevistaFamiliar?->campos['cota'] == 'Escola Pública' ? 'X' : ' ' }} )</td>
        </tr>
        <tr>
            <td><b>Indígenas</b></td>
            <td>( {{ $entrevistaFamiliar?->campos['cota'] == 'Indígenas' ? 'X' : ' ' }} )</td>
            <td><b>Ampla Concorrência</b></td>
            <td>( {{ $entrevistaFamiliar?->campos['cota'] == 'Ampla Concorrência' ? 'X' : ' ' }} )</td>
        </tr>
        <tr>
            <td><b>Entrada por sorteio público</b></td>
            <td>( {{ $entrevistaFamiliar?->campos['cota'] == 'Entrada por sorteio público' ? 'X' : ' ' }} )</td>
            <td><b>Quilombola</b></td>
            <td>( {{ $entrevistaFamiliar?->campos['cota'] == 'Quilombola' ? 'X' : ' ' }} )</td>
        </tr>
    </table>

    <p><b>4. Informações Familiares</b></p>
    <table class="table">
        <tr>
            <td colspan="2" class="text-center"><b>Mãe</b></td>
        </tr>
        <tr>
            <td style="width: 25%;"><b>Formação</b></td>
            <td>{{ $entrevistaFamiliar?->campos['formacaoMae'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Profissão</b></td>
            <td>{{ $entrevistaFamiliar?->campos['profissaoMae'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Idade</b></td>
            <td>{{ $entrevistaFamiliar?->campos['idadeMae'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Atualmente está empregada(o)?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['maeEmpregada'] ?? '' }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td colspan="2" class="text-center"><b>Pai</b></td>
        </tr>
        <tr>
            <td style="width:25%;"><b>Formação</b></td>
            <td>{{ $entrevistaFamiliar?->campos['formacaoPai'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Profissão</b></td>
            <td>{{ $entrevistaFamiliar?->campos['profissaoPai'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Idade</b></td>
            <td>{{ $entrevistaFamiliar?->campos['idadePai'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Atualmente está empregado?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['paiEmpregado'] ?? '' }}</td>
        </tr>
    </table>

    <table class="table mb-lg">
        <tr>
            <td colspan="2" class="text-center"><b>Responsável</b></td>
        </tr>
        <tr>
            <td style="width:25%;"><b>Formação</b></td>
            <td>{{ $entrevistaFamiliar?->campos['formacaoResponsavel'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Profissão</b></td>
            <td>{{ $entrevistaFamiliar?->campos['profissaoResponsavel'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Idade</b></td>
            <td>{{ $entrevistaFamiliar?->campos['idadeResponsavel'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Atualmente está empregado(a)?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['responsavelEmpregado'] ?? '' }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td style="width:50%;"><b>Número de irmãos</b></td>
            <td>{{ $entrevistaFamiliar?->campos['numeroIrmaos'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Estudante mora com</b></td>
            <td>{{ $entrevistaFamiliar?->campos['moraCom'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Pais separados?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['paisSeparados'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Alguma pessoa da família tem deficiência?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['deficiencia'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Se sim, qual?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['tipoDeficiencia'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Rotina diária antes e depois das aulas/atividades domésticas</b></td>
            <td>{{ $entrevistaFamiliar?->campos['rotinaDiaria'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Relacionamento com familiares</b></td>
            <td>{{ $entrevistaFamiliar?->campos['relacionamentoFamiliares'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Com quem mais convive fora da escola?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['comQuemConvive'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Mantém amizades com pessoas da mesma idade</b></td>
            <td>{{ $entrevistaFamiliar?->campos['mantemAmizades'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>A família se reúne para atividades de lazer? Que tipo?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['atividadesLazer'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Condições de moradia (casa própria, alugada, outro)</b></td>
            <td>{{ $entrevistaFamiliar?->campos['condicoesMoradia'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Tem ambiente específico para estudo? Como é?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['ambienteEstudo'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Há acompanhamento sobre o que acessa no computador? Ou sobre interações no celular?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['acompanhamento'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Qual o local da casa onde o estudante permanece mais tempo?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['localPermanencia'] ?? '' }}</td>
        </tr>
    </table>

    <p><b>5. História Escolar do Estudante</b></p>
    <table class="table">
        <tr>
            <td><b>Qual a escola de origem?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['escolaOrigem'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Há quanto tempo no IFPR?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['tempoIFPR'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Já reprovou algum ano escolar? Qual? Motivo?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['reprovacao'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Áreas de conhecimento com as quais têm mais facilidade na escola</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['areasFacilidade'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Áreas de conhecimento com as quais têm mais dificuldade na escola</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['areasDificuldade'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Trajetória escolar quanto a rendimentos, relacionamentos, adaptações, principais dificuldades e o que mais gostava. (Antecedentes relevantes)</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['trajetoriaEscolar'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Frequentou educação infantil a partir de que idade?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['frequentouEducacaoInfantil'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Com quantos anos aprendeu a ler e escrever?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['aprendeuLerEscrever'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Quais os cursos extra-escolares que já fez?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['cursosExtraEscolares'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['atendimentoEduacionalEspecializado'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Foi necessária alguma Adaptação Curricular? Qual(is)?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['adaptacaoCurricular'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Outras necessidades relatadas e/ou percebidas:</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['outrasNecessidades'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Potencialidades do estudante. Em quais atividades se destaca? Na escola ou fora dela.</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['potencialidades'] ?? '' }}</td>
        </tr>
    </table>

    <p><b>6. Desenvolvimento biopsicossocial</b></p>
    <table class="table">
        <tr>
            <td style="width: 30%;"><b>Gestação planejada/desejada</b></td>
            <td>{{ $entrevistaFamiliar?->campos['gestacaoPlanejada'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Fez pré-natal</b></td>
            <td>{{ $entrevistaFamiliar?->campos['fezPreNatal'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Doenças apresentadas</b></td>
            <td>{{ $entrevistaFamiliar?->campos['doencasApresentadas'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Usou fraldas até que idade</b></td>
            <td>{{ $entrevistaFamiliar?->campos['usouFraldas'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Até que idade fez uso de mamadeira, chupeta, outros recursos de segurança afetiva?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['ateQueIdadeMamadeira'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)</b></td>
            <td>{{ $entrevistaFamiliar?->campos['desenvolvimentoFalaAndar'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>As indicações de vacinação foram cumpridas? Se não, por que?</b></td>
            <td>{{ $entrevistaFamiliar?->campos['IndicacoesVacinacao'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Faz uso de medicamento</b></td>
            <td>{{ $entrevistaFamiliar?->campos['fazUsoMedicamento'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Seletividade ou restrição alimentar</b></td>
            <td>{{ $entrevistaFamiliar?->campos['seletividadeRestricaoAlimentar'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Internamentos e cirurgias</b></td>
            <td>{{ $entrevistaFamiliar?->campos['internamentosCirurgias'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)</b></td>
            <td>{{ $entrevistaFamiliar?->campos['deficienciaTranstornos'] ?? '' }}</td>
        </tr>
        <tr>
            <td colspan="2" class="bg-light">
                <b>Fez ou faz algum acompanhamento com profissional de Saúde externo?</b>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 0;">
                <table style="width: 100%;border-collapse: collapse;">
                    <tr class="bold">
                        <td>Área</td>
                        <td>Nome</td>
                        <td>Contato</td>
                    </tr>
                    <tr>
                        <td>Fisioterapia</td>
                        <td>{{ $entrevistaFamiliar?->campos['nomeFisioterapeuta'] ?? '' }}</td>
                        <td>{{ $entrevistaFamiliar?->campos['contatoFisioterapeuta'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Fonoaudiologia</td>
                        <td>{{ $entrevistaFamiliar?->campos['nomeFonoaudiologo'] ?? '' }}</td>
                        <td>{{ $entrevistaFamiliar?->campos['contatoFonoaudiologo'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Psicoterapia</td>
                        <td>{{ $entrevistaFamiliar?->campos['nomePsicologo'] ?? '' }}</td>
                        <td>{{ $entrevistaFamiliar?->campos['contatoPsicologo'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Neurologia</td>
                        <td>{{ $entrevistaFamiliar?->campos['nomeNeurologista'] ?? '' }}</td>
                        <td>{{ $entrevistaFamiliar?->campos['contatoNeurologista'] ?? '' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><b>Obs.:</b> {{ $entrevistaFamiliar?->campos['observacoes'] ?? '' }}</td>
        </tr>
    </table>

    <p><b>7. Características de comportamento do Estudante</b></p>
    <table class="table">
        <tr>
            <td>( {{ $entrevistaFamiliar?->campos['timido'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>tímido</td>
            <td>( {{ $entrevistaFamiliar?->campos['extrovertido'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>extrovertido</td>
            <td>( {{ $entrevistaFamiliar?->campos['persistente'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>persistente</td>
        </tr>
        <tr>
            <td>( {{ $entrevistaFamiliar?->campos['calmo'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>calmo</td>
            <td>( {{ $entrevistaFamiliar?->campos['agitado'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>agitado</td>
            <td>( {{ $entrevistaFamiliar?->campos['ansioso'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>ansioso</td>
        </tr>
        <tr>
            <td>( {{ $entrevistaFamiliar?->campos['organizado'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>organizado</td>
            <td>( {{ $entrevistaFamiliar?->campos['perfeccionista'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>perfeccionista</td>
            <td>( {{ $entrevistaFamiliar?->campos['responsavel'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>responsável</td>
        </tr>
        <tr>
            <td>( {{ $entrevistaFamiliar?->campos['amoroso'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>amoroso</td>
            <td>( {{ $entrevistaFamiliar?->campos['nervoso'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>nervoso</td>
            <td>( {{ $entrevistaFamiliar?->campos['inseguro'] == 'Sim' ? 'X' : ' ' }} )</td>
            <td>inseguro</td>
        </tr>
        <tr>
            <td colspan="6"><b>Outros:</b> {{ $entrevistaFamiliar?->campos['outros'] ?? '' }}</td>
        </tr>
    </table>

    <p><b>8. Informações Gerais e de âmbito escolar</b></p>
    <table class="table">
        <tr>
            <td><b>Origem e histórico do caso e dos atendimentos:</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['origemHistorico'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Faz uso de algum artefato para mobilidade?</b></td>    
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['artefatosMobilidade'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Há necessidade de adaptação de mobiliário? (carteira, rampas, apoio para pés, etc.)</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['adaptacaoMobiliario'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>É totalmente dependente para a locomoção na rampa, banheiros, sala de aula, laboratórios? Qual a necessidade?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['necessidadeLocacao'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Necessita de alguma adaptação para a utilização do computador? Qual?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['adaptacaoComputador'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Possui transporte para locomoção ao Campus? Necessita de auxílio para ingresso ao Campus?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['transporteCampus'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['atendimentoEducativo'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Foi necessária alguma Adaptação Curricular? Qual(is)?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['necessidadeAdaptacaoCurricular'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Sistema linguístico utilizado pelo estudante (Oral, gestual, LIBRAS, outros)</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['sistemaLinguistico'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Recursos ou equipamentos de acessibilidade já usados pelo estudante:</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['recursosAcessibilidade'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Recursos ou equipamentos que necessitam ser providenciados:</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['recursosProvidenciados'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Outras necessidades relatadas e/ou percebidas:</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['outrasNecessidadesEscolares'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Sugestões para melhoria da adaptação:</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['sugestoesAdaptacao'] ?? '' }}</td>
        </tr>
    </table>

    <p><b>CASO HAJA CONTATO COM ESCOLA ANTERIOR</b></p>
    <table class="table">
        <tr>
            <td><b>Teve acompanhamento de AEE? Fez uso da sala de recurso?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['acompanhamentoAEE'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Potencialidades e dificuldades acadêmicas</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['potencialidadesDificuldades'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Tinha material adaptado? Quais?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['materialAdaptado'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Participou de apoio escolar? Qual?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['apoioEscolar'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Algum comportamento diferenciado?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['comportamentoDiferenciado'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Alguma questão de sensibilidade?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['questaoSensibilidade'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Algum momento de crise? Que tipo?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['momentoCrise'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Teve laudo por encaminhamento da escola?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['laudoEscola'] ?? '' }}</td>
        </tr>
    </table>

    <p><b>CASO HAJA CONTATO COM PROFISSIONAIS EXTERNOS</b></p>
    <table class="table">
        <tr>
            <td><b>Quando começou o tratamento?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['inicioTratamento'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Por que começou?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['porQueComecou'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Apresenta crises de comportamento?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['apresentaCrisesComportamento'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Qual ou quais situações desencadeiam crises?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['qualSituacoesDesencadeiamCrises'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Orientações para evitar estresse.</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['orientacoesEvitarEstresse'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Quais as melhorias?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['quaisMelhorias'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Maiores orientações para sala de aula e escola</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['maioresOrientacoes'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Necessita de abafador de som no ambiente escolar?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['necessitaAbafadorSom'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Como o estudante se organiza? Utiliza agendas para registrar seus compromissos?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['comoSeOrganiza'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Como o estudante aprende?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['comoAprende'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Quais recursos e/ou estratégias facilitam sua aprendizagem?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['quaisRecursosFacilitam'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Quais recursos e/ou estratégias dificultam sua aprendizagem?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['quaisRecursosDificultam'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Em que área do conhecimento apresenta mais facilidade para aprender? Por quê?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['emQueAreaFacilidade'] ?? '' }}</td>
        </tr>
        <tr>
            <td><b>Em que área do conhecimento percebe mais dificuldade para aprender? Por quê?</b></td>
        </tr>
        <tr>
            <td>{{ $entrevistaFamiliar?->campos['emQueAreaDificuldade'] ?? '' }}</td>
        </tr>
    </table>
</x-layouts.pdf>

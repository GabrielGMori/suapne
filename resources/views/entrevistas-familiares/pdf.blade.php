@props(['entrevistaFamiliar' => null])

<?php
use App\Models\Estudante;

// Resolve once, guaranteed to be an array. This means every
// $campos['algumaChave'] access below is safe even if:
//   - $entrevistaFamiliar is null
//   - ->campos is null
//   - the key simply doesn't exist in the array
// (the ?? operator uses isset() semantics, so missing keys never warn/error)
$campos = $entrevistaFamiliar?->campos ?? [];
?>

<x-layouts.pdf>
    <p class="text-center mb-lg"><b>ENTREVISTA ESCOLAR</b></p>

    <table class="table">
        <tr>
            <td><b>Data:</b> {{ $entrevistaFamiliar?->data?->format('d/m/Y') }}</td>
            <td><b>Responsável pelo preenchimento:</b> {{ $entrevistaFamiliar?->user?->nome ?? '---' }}</td>
        </tr>
    </table>

    <p><b>1. Identificação do Estudante</b></p>
    <table class="table">
        <tr>
            <td style="width: 30%"><b>Nome completo</b></td>
            <td colspan="2">{{ $campos['nomeCompleto'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Nome social</b></td>
            <td colspan="2">{{ $campos['nomeSocial'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Idade</b></td>
            <td colspan="2">{{ $campos['idade'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Data de Nascimento</b></td>
            <td colspan="2">{{ $campos['dataNascimento'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Mãe</b></td>
            <td colspan="2">{{ $campos['nomeMae'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Pai</b></td>
            <td colspan="2">{{ $campos['nomePai'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Responsável</b></td>
            <td colspan="2">{{ $campos['nomeResponsavel'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Contatos</b></td>
            <td>
                Celular:<br>
                Estudante: {{ $campos['celularEstudante'] ?? '---' }}<br>
                Mãe: {{ $campos['celularMae'] ?? '---' }}<br>
                Pai: {{ $campos['celularPai'] ?? '---' }}<br>
                Fixo: {{ $campos['celularFixo'] ?? '---' }}
            </td>
            <td>
                E-mail:<br>
                Estudante: {{ $campos['emailEstudante'] ?? '---' }}<br>
                Mãe: {{ $campos['emailMae'] ?? '---' }}<br>
                Pai: {{ $campos['emailPai'] ?? '---' }}<br>
                Responsável: {{ $campos['emailResponsavel'] ?? '---' }}
            </td>
        </tr>
        <tr>
            <td><b>Em emergência pode ser chamado SAMU</b></td>
            <td colspan="2">
                SIM ( {{ ($campos['podeSerChamadoSAMU'] ?? '---') == 'Sim' ? 'X' : ' ' }} )
                NÃO ( {{ ($campos['podeSerChamadoSAMU'] ?? '---') == 'Não' ? 'X' : ' ' }} )
            </td>
        </tr>
    </table>

    <p><b>2. Identificação do curso</b></p>
    <table class="table">
        <tr>
            <td><b>Curso</b></td>
            <td>{{ $campos['nomeCurso'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Forma de Oferta:</b></td>
            <td>
                FIC ( {{ ($campos['formaOferta'] ?? '---') == 'FIC' ? 'X' : ' ' }} )
                Proeja ( {{ ($campos['formaOferta'] ?? '---') == 'Proeja' ? 'X' : ' ' }} )
                Integrado ( {{ ($campos['formaOferta'] ?? '---') == 'Integrado' ? 'X' : ' ' }} )
                Subsequente ( {{ ($campos['formaOferta'] ?? '---') == 'Subsequente' ? 'X' : ' ' }} )<br>
                Graduação - licenciatura ( {{ ($campos['formaOferta'] ?? '---') == 'Graduação - Licenciatura' ? 'X' : ' ' }} )
                Graduação - bacharelado ( {{ ($campos['formaOferta'] ?? '---') == 'Graduação - Bacharelado' ? 'X' : ' ' }} )
                Graduação - tecnólogo ( {{ ($campos['formaOferta'] ?? '---') == 'Graduação - Tecnólogo' ? 'X' : ' ' }} ) <br>
                Especialização ( {{ ($campos['formaOferta'] ?? '---') == 'Especialização' ? 'X' : ' ' }} )
                Mestrado ( {{ ($campos['formaOferta'] ?? '---') == 'Mestrado' ? 'X' : ' ' }} )
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding:0;">
                <table style="width: 100%; border:none; border-collapse:collapse;">
                    <tr>
                        <td><b>Matrícula</b></td>
                        <td>{{ $campos['matricula'] ?? '---' }}</td>
                        <td><b>Turno</b></td>
                        <td>{{ $campos['turno'] ?? '---' }}</td>
                        <td><b>Ano/Período</b></td>
                        <td>{{ $campos['anoPeriodo'] ?? '---' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p><b>3. Cota de Ingresso</b></p>
    <table class="table">
        <tr>
            <td><b>PNE</b></td>
            <td>( {{ ($campos['cota'] ?? '---') == 'PNE' ? 'X' : ' ' }} )</td>
            <td><b>Social</b></td>
            <td>( {{ ($campos['cota'] ?? '---') == 'Social' ? 'X' : ' ' }} )</td>
        </tr>
        <tr>
            <td><b>Pretos ou Pardos</b></td>
            <td>( {{ ($campos['cota'] ?? '---') == 'Pretos ou Pardos' ? 'X' : ' ' }} )</td>
            <td><b>Escola Pública</b></td>
            <td>( {{ ($campos['cota'] ?? '---') == 'Escola Pública' ? 'X' : ' ' }} )</td>
        </tr>
        <tr>
            <td><b>Indígenas</b></td>
            <td>( {{ ($campos['cota'] ?? '---') == 'Indígenas' ? 'X' : ' ' }} )</td>
            <td><b>Ampla Concorrência</b></td>
            <td>( {{ ($campos['cota'] ?? '---') == 'Ampla Concorrência' ? 'X' : ' ' }} )</td>
        </tr>
        <tr>
            <td><b>Entrada por sorteio público</b></td>
            <td>( {{ ($campos['cota'] ?? '---') == 'Entrada por sorteio público' ? 'X' : ' ' }} )</td>
            <td><b>Quilombola</b></td>
            <td>( {{ ($campos['cota'] ?? '---') == 'Quilombola' ? 'X' : ' ' }} )</td>
        </tr>
    </table>

    <p><b>4. Informações Familiares</b></p>
    <table class="table">
        <tr>
            <td colspan="2" class="text-center"><b>Mãe</b></td>
        </tr>
        <tr>
            <td style="width: 25%;"><b>Formação</b></td>
            <td>{{ $campos['formacaoMae'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Profissão</b></td>
            <td>{{ $campos['profissaoMae'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Idade</b></td>
            <td>{{ $campos['idadeMae'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Atualmente está empregada(o)?</b></td>
            <td>{{ $campos['maeEmpregada'] ?? '---' }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td colspan="2" class="text-center"><b>Pai</b></td>
        </tr>
        <tr>
            <td style="width:25%;"><b>Formação</b></td>
            <td>{{ $campos['formacaoPai'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Profissão</b></td>
            <td>{{ $campos['profissaoPai'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Idade</b></td>
            <td>{{ $campos['idadePai'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Atualmente está empregado?</b></td>
            <td>{{ $campos['paiEmpregado'] ?? '---' }}</td>
        </tr>
    </table>

    <table class="table mb-lg">
        <tr>
            <td colspan="2" class="text-center"><b>Responsável</b></td>
        </tr>
        <tr>
            <td style="width:25%;"><b>Formação</b></td>
            <td>{{ $campos['formacaoResponsavel'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Profissão</b></td>
            <td>{{ $campos['profissaoResponsavel'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Idade</b></td>
            <td>{{ $campos['idadeResponsavel'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Atualmente está empregado(a)?</b></td>
            <td>{{ $campos['responsavelEmpregado'] ?? '---' }}</td>
        </tr>
    </table>

    <table class="table">
        <tr>
            <td style="width:50%;"><b>Número de irmãos</b></td>
            <td>{{ $campos['numeroIrmaos'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Estudante mora com</b></td>
            <td>{{ $campos['moraCom'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Pais separados?</b></td>
            <td>{{ $campos['paisSeparados'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Alguma pessoa da família tem deficiência?</b></td>
            <td>{{ $campos['deficiencia'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Se sim, qual?</b></td>
            <td>{{ $campos['tipoDeficiencia'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Rotina diária antes e depois das aulas/atividades domésticas</b></td>
            <td>{{ $campos['rotinaDiaria'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Relacionamento com familiares</b></td>
            <td>{{ $campos['relacionamentoFamiliares'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Com quem mais convive fora da escola?</b></td>
            <td>{{ $campos['comQuemConvive'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Mantém amizades com pessoas da mesma idade</b></td>
            <td>{{ $campos['mantemAmizades'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>A família se reúne para atividades de lazer? Que tipo?</b></td>
            <td>{{ $campos['atividadesLazer'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Condições de moradia (casa própria, alugada, outro)</b></td>
            <td>{{ $campos['condicoesMoradia'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Tem ambiente específico para estudo? Como é?</b></td>
            <td>{{ $campos['ambienteEstudo'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Há acompanhamento sobre o que acessa no computador? Ou sobre interações no celular?</b></td>
            <td>{{ $campos['acompanhamento'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Qual o local da casa onde o estudante permanece mais tempo?</b></td>
            <td>{{ $campos['localPermanencia'] ?? '---' }}</td>
        </tr>
    </table>

    <p><b>5. História Escolar do Estudante</b></p>
    <table class="table">
        <tr>
            <td><b>Qual a escola de origem?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['escolaOrigem'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Há quanto tempo no IFPR?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['tempoIFPR'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Já reprovou algum ano escolar? Qual? Motivo?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['reprovacao'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Áreas de conhecimento com as quais têm mais facilidade na escola</b></td>
        </tr>
        <tr>
            <td>{{ $campos['areasFacilidade'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Áreas de conhecimento com as quais têm mais dificuldade na escola</b></td>
        </tr>
        <tr>
            <td>{{ $campos['areasDificuldade'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Trajetória escolar quanto a rendimentos, relacionamentos, adaptações, principais dificuldades e o que mais gostava. (Antecedentes relevantes)</b></td>
        </tr>
        <tr>
            <td>{{ $campos['trajetoriaEscolar'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Frequentou educação infantil a partir de que idade?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['frequentouEducacaoInfantil'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Com quantos anos aprendeu a ler e escrever?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['aprendeuLerEscrever'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Quais os cursos extra-escolares que já fez?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['cursosExtraEscolares'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['atendimentoEduacionalEspecializado'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Foi necessária alguma Adaptação Curricular? Qual(is)?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['adaptacaoCurricular'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Outras necessidades relatadas e/ou percebidas:</b></td>
        </tr>
        <tr>
            <td>{{ $campos['outrasNecessidades'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Potencialidades do estudante. Em quais atividades se destaca? Na escola ou fora dela.</b></td>
        </tr>
        <tr>
            <td>{{ $campos['potencialidades'] ?? '---' }}</td>
        </tr>
    </table>

    <p><b>6. Desenvolvimento biopsicossocial</b></p>
    <table class="table">
        <tr>
            <td style="width: 30%;"><b>Gestação planejada/desejada</b></td>
            <td>{{ $campos['gestacaoPlanejada'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Fez pré-natal</b></td>
            <td>{{ $campos['fezPreNatal'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Doenças apresentadas</b></td>
            <td>{{ $campos['doencasApresentadas'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Usou fraldas até que idade</b></td>
            <td>{{ $campos['usouFraldas'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Até que idade fez uso de mamadeira, chupeta, outros recursos de segurança afetiva?</b></td>
            <td>{{ $campos['ateQueIdadeMamadeira'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Como foi o desenvolvimento da fala, do andar, alimentação e controle de esfíncteres (em que idade passou a ter independência nas atividades cotidianas)</b></td>
            <td>{{ $campos['desenvolvimentoFalaAndar'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>As indicações de vacinação foram cumpridas? Se não, por que?</b></td>
            <td>{{ $campos['IndicacoesVacinacao'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Faz uso de medicamento</b></td>
            <td>{{ $campos['fazUsoMedicamento'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Seletividade ou restrição alimentar</b></td>
            <td>{{ $campos['seletividadeRestricaoAlimentar'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Internamentos e cirurgias</b></td>
            <td>{{ $campos['internamentosCirurgias'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Deficiência, Dificuldade, Transtorno ou Altas Habilidades (Diagnóstico e histórico do caso e atendimentos)</b></td>
            <td>{{ $campos['deficienciaTranstornos'] ?? '---' }}</td>
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
                        <td>{{ $campos['nomeFisioterapeuta'] ?? '---' }}</td>
                        <td>{{ $campos['contatoFisioterapeuta'] ?? '---' }}</td>
                    </tr>
                    <tr>
                        <td>Fonoaudiologia</td>
                        <td>{{ $campos['nomeFonoaudiologo'] ?? '---' }}</td>
                        <td>{{ $campos['contatoFonoaudiologo'] ?? '---' }}</td>
                    </tr>
                    <tr>
                        <td>Psicoterapia</td>
                        <td>{{ $campos['nomePsicologo'] ?? '---' }}</td>
                        <td>{{ $campos['contatoPsicologo'] ?? '---' }}</td>
                    </tr>
                    <tr>
                        <td>Neurologia</td>
                        <td>{{ $campos['nomeNeurologista'] ?? '---' }}</td>
                        <td>{{ $campos['contatoNeurologista'] ?? '---' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><b>Obs.:</b> {{ $campos['observacoes'] ?? '---' }}</td>
        </tr>
    </table>

    <p><b>7. Características de comportamento do Estudante</b></p>
    <table class="table">
        <tr>
            <td>( {{ ($campos['timido'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>tímido</td>
            <td>( {{ ($campos['extrovertido'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>extrovertido</td>
            <td>( {{ ($campos['persistente'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>persistente</td>
        </tr>
        <tr>
            <td>( {{ ($campos['calmo'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>calmo</td>
            <td>( {{ ($campos['agitado'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>agitado</td>
            <td>( {{ ($campos['ansioso'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>ansioso</td>
        </tr>
        <tr>
            <td>( {{ ($campos['organizado'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>organizado</td>
            <td>( {{ ($campos['perfeccionista'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>perfeccionista</td>
            <td>( {{ ($campos['responsavel'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>responsável</td>
        </tr>
        <tr>
            <td>( {{ ($campos['amoroso'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>amoroso</td>
            <td>( {{ ($campos['nervoso'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>nervoso</td>
            <td>( {{ ($campos['inseguro'] ?? '---') == 'Sim' ? 'X' : ' ' }} )</td>
            <td>inseguro</td>
        </tr>
        <tr>
            <td colspan="6"><b>Outros:</b> {{ $campos['outros'] ?? '---' }}</td>
        </tr>
    </table>

    <p><b>8. Informações Gerais e de âmbito escolar</b></p>
    <table class="table">
        <tr>
            <td><b>Origem e histórico do caso e dos atendimentos:</b></td>
        </tr>
        <tr>
            <td>{{ $campos['origemHistorico'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Faz uso de algum artefato para mobilidade?</b></td>    
        </tr>
        <tr>
            <td>{{ $campos['artefatosMobilidade'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Há necessidade de adaptação de mobiliário? (carteira, rampas, apoio para pés, etc.)</b></td>
        </tr>
        <tr>
            <td>{{ $campos['adaptacaoMobiliario'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>É totalmente dependente para a locomoção na rampa, banheiros, sala de aula, laboratórios? Qual a necessidade?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['necessidadeLocacao'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Necessita de alguma adaptação para a utilização do computador? Qual?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['adaptacaoComputador'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Possui transporte para locomoção ao Campus? Necessita de auxílio para ingresso ao Campus?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['transporteCampus'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Já teve atendimento educacional especializado? Como, onde e por quanto tempo foi? Quem prestava o atendimento?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['atendimentoEducativo'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Foi necessária alguma Adaptação Curricular? Qual(is)?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['necessidadeAdaptacaoCurricular'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Sistema linguístico utilizado pelo estudante (Oral, gestual, LIBRAS, outros)</b></td>
        </tr>
        <tr>
            <td>{{ $campos['sistemaLinguistico'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Recursos ou equipamentos de acessibilidade já usados pelo estudante:</b></td>
        </tr>
        <tr>
            <td>{{ $campos['recursosAcessibilidade'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Recursos ou equipamentos que necessitam ser providenciados:</b></td>
        </tr>
        <tr>
            <td>{{ $campos['recursosProvidenciados'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Outras necessidades relatadas e/ou percebidas:</b></td>
        </tr>
        <tr>
            <td>{{ $campos['outrasNecessidadesEscolares'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Sugestões para melhoria da adaptação:</b></td>
        </tr>
        <tr>
            <td>{{ $campos['sugestoesAdaptacao'] ?? '---' }}</td>
        </tr>
    </table>

    <p><b>CASO HAJA CONTATO COM ESCOLA ANTERIOR</b></p>
    <table class="table">
        <tr>
            <td><b>Teve acompanhamento de AEE? Fez uso da sala de recurso?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['acompanhamentoAEE'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Potencialidades e dificuldades acadêmicas</b></td>
        </tr>
        <tr>
            <td>{{ $campos['potencialidadesDificuldades'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Tinha material adaptado? Quais?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['materialAdaptado'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Participou de apoio escolar? Qual?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['apoioEscolar'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Algum comportamento diferenciado?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['comportamentoDiferenciado'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Alguma questão de sensibilidade?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['questaoSensibilidade'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Algum momento de crise? Que tipo?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['momentoCrise'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Teve laudo por encaminhamento da escola?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['laudoEscola'] ?? '---' }}</td>
        </tr>
    </table>

    <p><b>CASO HAJA CONTATO COM PROFISSIONAIS EXTERNOS</b></p>
    <table class="table">
        <tr>
            <td><b>Quando começou o tratamento?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['inicioTratamento'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Por que começou?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['porQueComecou'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Apresenta crises de comportamento?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['apresentaCrisesComportamento'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Qual ou quais situações desencadeiam crises?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['qualSituacoesDesencadeiamCrises'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Orientações para evitar estresse.</b></td>
        </tr>
        <tr>
            <td>{{ $campos['orientacoesEvitarEstresse'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Quais as melhorias?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['quaisMelhorias'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Maiores orientações para sala de aula e escola</b></td>
        </tr>
        <tr>
            <td>{{ $campos['maioresOrientacoes'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Necessita de abafador de som no ambiente escolar?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['necessitaAbafadorSom'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Como o estudante se organiza? Utiliza agendas para registrar seus compromissos?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['comoSeOrganiza'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Como o estudante aprende?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['comoAprende'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Quais recursos e/ou estratégias facilitam sua aprendizagem?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['quaisRecursosFacilitam'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Quais recursos e/ou estratégias dificultam sua aprendizagem?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['quaisRecursosDificultam'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Em que área do conhecimento apresenta mais facilidade para aprender? Por quê?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['emQueAreaFacilidade'] ?? '---' }}</td>
        </tr>
        <tr>
            <td><b>Em que área do conhecimento percebe mais dificuldade para aprender? Por quê?</b></td>
        </tr>
        <tr>
            <td>{{ $campos['emQueAreaDificuldade'] ?? '---' }}</td>
        </tr>
    </table>
</x-layouts.pdf>

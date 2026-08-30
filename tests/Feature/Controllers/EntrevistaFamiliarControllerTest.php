<?php

use App\Enums\RoleEnum;
use App\Models\Curso;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use App\Models\User;

beforeEach(function () {
    $this->curso = Curso::factory()->create();
    $this->estudante = Estudante::factory()->create(['curso_id' => $this->curso->id]);
    $this->admin = User::factory()->create(['role' => RoleEnum::DOCENTE_ESPECIAL]);
    $this->tecnico = User::factory()->create(['role' => RoleEnum::TECNICO]);
});

test('admin can access create and show entrevista familiar', function () {
    $entrevista = EntrevistaFamiliar::factory()->create([
        'estudante_id' => $this->estudante->id,
        'user_id' => $this->admin->id,
        'campos' => [
            'nomeCompleto' => 'Estudante Teste',
            'nomeSocial' => 'Teste',
            'idade' => 18,
            'dataNascimento' => '10/05/2005',
            'nomeMae' => 'Mãe Teste',
            'nomePai' => 'Pai Teste',
            'nomeResponsavel' => 'Responsável Teste',
            'celularEstudante' => '(41) 99999-9999',
            'celularMae' => '(41) 99999-9999',
            'celularPai' => '(41) 99999-9999',
            'celularFixo' => '(41) 3333-3333',
            'emailEstudante' => 'estudante@ifpr.edu.br',
            'emailMae' => 'mae@teste.com',
            'emailPai' => 'pai@teste.com',
            'emailResponsavel' => 'resp@teste.com',
            'podeSerChamadoSAMU' => 'Sim',
            'nomeCurso' => 'Informática',
            'formaOferta' => 'Integrado',
            'matricula' => '20260001',
            'turno' => 'Matutino',
            'anoPeriodo' => '1º Ano',
            'cota' => 'Não',
            'formacaoMae' => 'Superior',
            'profissaoMae' => 'Engenheira',
            'idadeMae' => 45,
            'maeEmpregada' => 'Sim',
            'formacaoPai' => 'Superior',
            'profissaoPai' => 'Advogado',
            'idadePai' => 48,
            'paiEmpregado' => 'Sim',
            'formacaoResponsavel' => 'Superior',
            'profissaoResponsavel' => 'Advogado',
            'idadeResponsavel' => 48,
            'responsavelEmpregado' => 'Sim',
            'numeroIrmaos' => '1',
            'moraCom' => 'Pais',
            'paisSeparados' => 'Não',
            'relacionamentoFamiliares' => 'Bom',
            'comQuemConvive' => 'Família',
            'mantemAmizades' => 'Sim',
            'atividadesLazer' => 'Jogos',
            'condicoesMoradia' => 'Própria',
            'ambienteEstudo' => 'Quarto individual',
            'escolaOrigem' => 'Escola Pública',
            'tempoIFPR' => '1 ano',
            'reprovacao' => 'Não',
            'areasFacilidade' => 'Matemática',
            'areasDificuldade' => 'História',
            'trajetoriaEscolar' => 'Regular',
            'frequentouEducacaoInfantil' => 'Sim',
            'aprendeuLerEscrever' => '6 anos',
            'cursosExtraEscolares' => 'Inglês',
            'atendimentoEduacionalEspecializado' => 'Não',
            'adaptacaoCurricular' => 'Não',
            'deficiencia' => 'TDAH',
            'tipoDeficiencia' => 'TDAH',
            'gestacaoPlanejada' => 'Sim',
            'fezPreNatal' => 'Sim',
            'doencasApresentadas' => 'Nenhuma',
            'usouFraldas' => 'Até 2 anos',
            'ateQueIdadeMamadeira' => '2 anos',
            'desenvolvimentoFalaAndar' => 'Normal',
            'IndicacoesVacinacao' => 'Em dia',
            'fazUsoMedicamento' => 'Não',
            'seletividadeRestricaoAlimentar' => 'Não',
            'internamentosCirurgias' => 'Não',
            'deficienciaTranstornos' => 'TDAH',
            'acompanhamentoSaudeExterno' => 'Psicólogo',
            'rotinaDiaria' => 'Estudos e descanso',
            'timido' => 'Não',
            'extrovertido' => 'Sim',
            'persistente' => 'Sim',
            'calmo' => 'Sim',
            'agitado' => 'Não',
            'ansioso' => 'Não',
            'organizado' => 'Sim',
            'perfeccionista' => 'Não',
            'responsavel' => 'Sim',
            'amoroso' => 'Sim',
            'nervoso' => 'Não',
            'inseguro' => 'Não',
            'origemHistorico' => 'Histórico familiar',
            'artefatosMobilidade' => 'Nenhum',
            'adaptacaoMobiliario' => 'Não',
            'necessidadeLocacao' => 'Não',
            'adaptacaoComputador' => 'Não',
            'transporteCampus' => 'Ônibus',
            'atendimentoEducativo' => 'Sim',
            'necessidadeAdaptacaoCurricular' => 'Não',
            'sistemaLinguistico' => 'Português',
            'recursosAcessibilidade' => 'Nenhum',
            'recursosProvidenciados' => 'Nenhum',
            'outrasNecessidades' => 'Nenhuma',
            'outrasNecessidadesEscolares' => 'Nenhuma',
            'sugestoesAdaptacao' => 'Nenhuma',
            'potencialidades' => 'Concentração',
            'potencialidadesDificuldades' => 'Nenhuma',
            'materialAdaptado' => 'Não',
            'apoioEscolar' => 'Não',
            'comportamentoDiferenciado' => 'Não',
            'questaoSensibilidade' => 'Não',
            'momentoCrise' => 'Não',
            'laudoEscola' => 'Não',
            'inicioTratamento' => '2020',
            'porQueComecou' => 'Avaliação',
            'apresentaCrisesComportamento' => 'Não',
            'qualSituacoesDesencadeiamCrises' => 'Nenhuma',
            'orientacoesEvitarEstresse' => 'Ambiente calmo',
            'quaisMelhorias' => 'Muitas',
            'maioresOrientacoes' => 'Paciência',
            'necessitaAbafadorSom' => 'Não',
            'comoSeOrganiza' => 'Agenda',
            'comoAprende' => 'Visual',
            'quaisRecursosFacilitam' => 'Esquemas',
            'quaisRecursosDificultam' => 'Barulho',
            'emQueAreaFacilidade' => 'Exatas',
            'emQueAreaDificuldade' => 'Humanas',
            'localPermanencia' => 'Quarto',
            'acompanhamento' => 'Acompanhamento trimestral',
            'outros' => 'Nenhum',
            'nomeFisioterapeuta' => 'Dra. Ana',
            'contatoFisioterapeuta' => '(41) 99999-9999',
            'nomeFonoaudiologo' => 'Dra. Bia',
            'contatoFonoaudiologo' => '(41) 99999-9999',
            'nomePsicologo' => 'Dra. Carla',
            'contatoPsicologo' => '(41) 99999-9999',
            'nomeNeurologista' => 'Dr. Daniel',
            'contatoNeurologista' => '(41) 99999-9999',
            'observacoes' => 'Sem observações adicionais.',
            'acompanhamentoAEE' => 'Não',
        ],
    ]);

    $this->actingAs($this->admin)
        ->get(route('estudantes.entrevistas-familiares.create', ['estudante' => $this->estudante]))
        ->assertStatus(200);

    $this->actingAs($this->admin)
        ->get(route('estudantes.entrevistas-familiares.show', [
            'estudante' => $this->estudante,
            'entrevistaFamiliar' => $entrevista,
        ]))
        ->assertStatus(200);
});

test('unauthorized user cannot access entrevista familiar create', function () {
    $this->actingAs($this->tecnico)
        ->get(route('estudantes.entrevistas-familiares.create', ['estudante' => $this->estudante]))
        ->assertStatus(404);
});

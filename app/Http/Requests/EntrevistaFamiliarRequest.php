<?php

namespace App\Http\Requests;

use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EntrevistaFamiliarRequest extends FormRequest
{
    public function authorize(): bool
    {
        $entrevista = $this->route('entrevistaFamiliar');
        if ($entrevista) {
            return $this->user()->can('update', $entrevista);
        }

        return $this->user()->can('create', EntrevistaFamiliar::class);
    }

    protected function prepareForValidation(): void
    {
        $estudante = $this->route('estudante');

        $this->merge([
            'user_id' => Auth::id(),
            'estudante_id' => $estudante instanceof Estudante ? $estudante->id : $estudante,
        ]);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'estudante_id' => ['required', 'integer', 'exists:estudantes,id'],
            'data' => ['required', 'date'],
            'responsavel_preenchimento' => ['required', 'string', 'max:200'],
            'campos' => ['required', 'array'],

            'campos.nomeCompleto' => ['nullable', 'string', 'max:255'],
            'campos.nomeSocial' => ['nullable', 'string', 'max:255'],
            'campos.dataNascimento' => ['nullable', 'date'],
            'campos.nomeMae' => ['nullable', 'string', 'max:255'],
            'campos.nomePai' => ['nullable', 'string', 'max:255'],
            'campos.nomeResponsavel' => ['nullable', 'string', 'max:255'],
            'campos.idade' => ['nullable', 'integer', 'min:0', 'max:140'],
            'campos.celularEstudante' => ['nullable', 'string', 'max:50'],
            'campos.celularMae' => ['nullable', 'string', 'max:50'],
            'campos.celularPai' => ['nullable', 'string', 'max:50'],
            'campos.celularFixo' => ['nullable', 'string', 'max:50'],
            'campos.emailEstudante' => ['nullable', 'email', 'max:255'],
            'campos.emailMae' => ['nullable', 'email', 'max:255'],
            'campos.emailPai' => ['nullable', 'email', 'max:255'],
            'campos.emailResponsavel' => ['nullable', 'email', 'max:255'],
            'campos.podeSerChamadoSAMU' => ['nullable', 'string', 'max:50'],

            'campos.nomeCurso' => ['nullable', 'string', 'max:255'],
            'campos.formaOferta' => ['nullable', 'string', 'max:255'],
            'campos.matricula' => ['nullable', 'string', 'max:50'],
            'campos.turno' => ['nullable', 'string', 'max:50'],
            'campos.anoPeriodo' => ['nullable', 'string', 'max:50'],
            'campos.cota' => ['nullable', 'string', 'max:255'],
            'campos.escolaOrigem' => ['nullable', 'string', 'max:255'],
            'campos.tempoIFPR' => ['nullable', 'string', 'max:100'],
            'campos.reprovacao' => ['nullable', 'string'],
            'campos.areasFacilidade' => ['nullable', 'string'],
            'campos.areasDificuldade' => ['nullable', 'string'],
            'campos.trajetoriaEscolar' => ['nullable', 'string'],
            'campos.frequentouEducacaoInfantil' => ['nullable', 'string'],
            'campos.aprendeuLerEscrever' => ['nullable', 'string'],
            'campos.cursosExtraEscolares' => ['nullable', 'string'],
            'campos.atendimentoEduacionalEspecializado' => ['nullable', 'string'],
            'campos.adaptacaoCurricular' => ['nullable', 'string'],

            'campos.formacaoMae' => ['nullable', 'string', 'max:255'],
            'campos.profissaoMae' => ['nullable', 'string', 'max:255'],
            'campos.idadeMae' => ['nullable', 'integer', 'min:0', 'max:140'],
            'campos.maeEmpregada' => ['nullable', 'string', 'max:255'],
            'campos.formacaoPai' => ['nullable', 'string', 'max:255'],
            'campos.profissaoPai' => ['nullable', 'string', 'max:255'],
            'campos.idadePai' => ['nullable', 'integer', 'min:0', 'max:140'],
            'campos.paiEmpregado' => ['nullable', 'string', 'max:255'],
            'campos.formacaoResponsavel' => ['nullable', 'string', 'max:255'],
            'campos.profissaoResponsavel' => ['nullable', 'string', 'max:255'],
            'campos.idadeResponsavel' => ['nullable', 'integer', 'min:0', 'max:140'],
            'campos.responsavelEmpregado' => ['nullable', 'string', 'max:255'],
            'campos.numeroIrmaos' => ['nullable', 'string', 'max:50'],
            'campos.moraCom' => ['nullable', 'string', 'max:255'],
            'campos.paisSeparados' => ['nullable', 'string', 'max:50'],
            'campos.relacionamentoFamiliares' => ['nullable', 'string'],
            'campos.comQuemConvive' => ['nullable', 'string'],
            'campos.mantemAmizades' => ['nullable', 'string'],
            'campos.atividadesLazer' => ['nullable', 'string'],
            'campos.condicoesMoradia' => ['nullable', 'string'],
            'campos.ambienteEstudo' => ['nullable', 'string'],

            'campos.deficiencia' => ['nullable', 'string', 'max:50'],
            'campos.tipoDeficiencia' => ['nullable', 'string'],
            'campos.gestacaoPlanejada' => ['nullable', 'string'],
            'campos.fezPreNatal' => ['nullable', 'string', 'max:50'],
            'campos.doencasApresentadas' => ['nullable', 'string'],
            'campos.usouFraldas' => ['nullable', 'string'],
            'campos.ateQueIdadeMamadeira' => ['nullable', 'string'],
            'campos.desenvolvimentoFalaAndar' => ['nullable', 'string'],
            'campos.IndicacoesVacinacao' => ['nullable', 'string'],
            'campos.fazUsoMedicamento' => ['nullable', 'string'],
            'campos.seletividadeRestricaoAlimentar' => ['nullable', 'string'],
            'campos.internamentosCirurgias' => ['nullable', 'string'],
            'campos.deficienciaTranstornos' => ['nullable', 'string'],
            'campos.acompanhamentoSaudeExterno' => ['nullable', 'string'],

            'campos.nomeFisioterapeuta' => ['nullable', 'string', 'max:255'],
            'campos.contatoFisioterapeuta' => ['nullable', 'string', 'max:50'],
            'campos.nomeFonoaudiologo' => ['nullable', 'string', 'max:255'],
            'campos.contatoFonoaudiologo' => ['nullable', 'string', 'max:50'],
            'campos.nomePsicologo' => ['nullable', 'string', 'max:255'],
            'campos.contatoPsicologo' => ['nullable', 'string', 'max:50'],
            'campos.nomeNeurologista' => ['nullable', 'string', 'max:255'],
            'campos.contatoNeurologista' => ['nullable', 'string', 'max:50'],

            'campos.rotinaDiaria' => ['nullable', 'string'],
            'campos.timido' => ['nullable', 'string', 'max:50'],
            'campos.extrovertido' => ['nullable', 'string', 'max:50'],
            'campos.persistente' => ['nullable', 'string', 'max:50'],
            'campos.calmo' => ['nullable', 'string', 'max:50'],
            'campos.agitado' => ['nullable', 'string', 'max:50'],
            'campos.ansioso' => ['nullable', 'string', 'max:50'],
            'campos.organizado' => ['nullable', 'string', 'max:50'],
            'campos.perfeccionista' => ['nullable', 'string', 'max:50'],
            'campos.responsavel' => ['nullable', 'string', 'max:50'],
            'campos.amoroso' => ['nullable', 'string', 'max:50'],
            'campos.nervoso' => ['nullable', 'string', 'max:50'],
            'campos.inseguro' => ['nullable', 'string', 'max:50'],

            'campos.origemHistorico' => ['nullable', 'string'],
            'campos.artefatosMobilidade' => ['nullable', 'string'],
            'campos.adaptacaoMobiliario' => ['nullable', 'string'],
            'campos.necessidadeLocacao' => ['nullable', 'string'],
            'campos.adaptacaoComputador' => ['nullable', 'string'],
            'campos.transporteCampus' => ['nullable', 'string'],
            'campos.atendimentoEducativo' => ['nullable', 'string'],
            'campos.necessidadeAdaptacaoCurricular' => ['nullable', 'string'],
            'campos.sistemaLinguistico' => ['nullable', 'string'],
            'campos.recursosAcessibilidade' => ['nullable', 'string'],
            'campos.recursosProvidenciados' => ['nullable', 'string'],
            'campos.outrasNecessidades' => ['nullable', 'string'],
            'campos.outrasNecessidadesEscolares' => ['nullable', 'string'],
            'campos.sugestoesAdaptacao' => ['nullable', 'string'],
            'campos.potencialidades' => ['nullable', 'string'],
            'campos.acompanhamentoAEE' => ['nullable', 'string'],
            'campos.potencialidadesDificuldades' => ['nullable', 'string'],
            'campos.materialAdaptado' => ['nullable', 'string'],
            'campos.apoioEscolar' => ['nullable', 'string'],
            'campos.comportamentoDiferenciado' => ['nullable', 'string'],
            'campos.questaoSensibilidade' => ['nullable', 'string'],
            'campos.momentoCrise' => ['nullable', 'string'],
            'campos.laudoEscola' => ['nullable', 'string'],
            'campos.inicioTratamento' => ['nullable', 'string'],
            'campos.porQueComecou' => ['nullable', 'string'],
            'campos.apresentaCrisesComportamento' => ['nullable', 'string'],
            'campos.qualSituacoesDesencadeiamCrises' => ['nullable', 'string'],
            'campos.orientacoesEvitarEstresse' => ['nullable', 'string'],
            'campos.quaisMelhorias' => ['nullable', 'string'],
            'campos.maioresOrientacoes' => ['nullable', 'string'],
            'campos.necessitaAbafadorSom' => ['nullable', 'string'],
            'campos.comoSeOrganiza' => ['nullable', 'string'],
            'campos.comoAprende' => ['nullable', 'string'],
            'campos.quaisRecursosFacilitam' => ['nullable', 'string'],
            'campos.quaisRecursosDificultam' => ['nullable', 'string'],
            'campos.emQueAreaFacilidade' => ['nullable', 'string'],
            'campos.emQueAreaDificuldade' => ['nullable', 'string'],
            'campos.localPermanencia' => ['nullable', 'string'],
            'campos.acompanhamento' => ['nullable', 'string'],
            'campos.observacoes' => ['nullable', 'string'],
            'campos.outros' => ['nullable', 'string'],
        ];
    }
}

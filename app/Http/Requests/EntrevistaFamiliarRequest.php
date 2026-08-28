<?php

namespace App\Http\Requests;

use App\Models\EntrevistaFamiliar;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EntrevistaFamiliarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', EntrevistaFamiliar::class);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
            'estudante_id' => $this->route('estudante')->id,
        ]);
    }

    public function rules(): array
    {

        $entrevista = $this->route('estudantes.entrevistas-familiares');

        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'estudante_id' => ['required', 'integer', 'exists:estudantes,id'],
            'data' => ['required', 'date'],
            'campos' => ['required', 'array'],

            'campos.nomeCompleto' => ['required', 'string', 'max:255'],
            'campos.nomeSocial' => ['required', 'string', 'max:255'],
            'campos.dataNascimento' => ['required', 'date'],
            'campos.nomeMae' => ['required', 'string', 'max:255'],
            'campos.nomePai' => ['required', 'string', 'max:255'],
            'campos.nomeResponsavel' => ['required', 'string', 'max:255'],
            'campos.idade' => ['required','integer','min:0','max:140'],
            'campos.celularEstudante' => ['required', 'string', 'min:10', 'max:20'],
            'campos.celularMae' => ['required', 'string', 'min:10', 'max:20'],
            'campos.celularPai' => ['required', 'string', 'min:10', 'max:20'],
            'campos.celularFixo' => ['nullable', 'string', 'min:10', 'max:20'],
            'campos.emailEstudante' => ['required', 'email', 'max:255'],
            'campos.emailMae' => ['required', 'email', 'max:255'],
            'campos.emailPai' => ['required', 'email', 'max:255'],
            'campos.emailResponsavel' => ['required', 'email', 'max:255'],
            'campos.podeSerChamadoSAMU' => ['required', 'string'],

            'campos.nomeCurso' => ['required', 'string', 'max:255'],
            'campos.formaOferta' => ['required', 'string', 'max:255'],
            'campos.matricula' => ['required', 'string', 'max:50'],
            'campos.turno'=> ['required','string'],
            'campos.anoPeriodo' => ['required', 'string', 'max:50'],
            'campos.cota' => ['required', 'string', 'max:255'],
            'campos.escolaOrigem' => ['required', 'string', 'max:255'],
            'campos.tempoIFPR' => ['required', 'string', 'max:100'],
            'campos.reprovacao' => ['required', 'string'],
            'campos.areasFacilidade' => ['required', 'string'],
            'campos.areasDificuldade' => ['required', 'string'],
            'campos.trajetoriaEscolar' => ['required', 'string'],
            'campos.frequentouEducacaoInfantil' => ['required', 'string'],
            'campos.aprendeuLerEscrever' => ['required', 'string'],
            'campos.cursosExtraEscolares' => ['required', 'string'],
            'campos.atendimentoEduacionalEspecializado' => ['required', 'string'],
            'campos.adaptacaoCurricular' => ['required', 'string'],

            'campos.formacaoMae' => ['required', 'string', 'max:255'],
            'campos.profissaoMae' => ['required', 'string', 'max:255'],
            'campos.idadeMae' => ['required', 'integer', 'min:10','max:140'],
            'campos.maeEmpregada' => ['required', 'string'],
            'campos.formacaoPai' => ['required', 'string', 'max:255'],
            'campos.profissaoPai' => ['required', 'string', 'max:255'],
            'campos.idadePai' => ['required', 'integer', 'min:10', 'max:140'],
            'campos.paiEmpregado' => ['required', 'string'],
            'campos.formacaoResponsavel' => ['required', 'string', 'max:255'],
            'campos.profissaoResponsavel' => ['required', 'string', 'max:255'],
            'campos.idadeResponsavel' => ['required', 'integer', 'min:10', 'max:140'],
            'campos.responsavelEmpregado' => ['required', 'string'],
            'campos.numeroIrmaos' => ['required', 'string'],
            'campos.moraCom' => ['required', 'string', 'max:255'],
            'campos.paisSeparados' => ['required', 'string'],
            'campos.relacionamentoFamiliares' => ['required', 'string'],
            'campos.comQuemConvive' => ['required', 'string'],
            'campos.mantemAmizades' => ['required', 'string'],
            'campos.atividadesLazer' => ['required', 'string'],
            'campos.condicoesMoradia' => ['required', 'string'],
            'campos.ambienteEstudo' => ['required', 'string'],

            'campos.deficiencia' => ['required', 'string'],
            'campos.tipoDeficiencia' => ['nullable', 'string'],
            'campos.gestacaoPlanejada' => ['required', 'string'],
            'campos.fezPreNatal' => ['required', 'string'],
            'campos.doencasApresentadas' => ['required', 'string'],
            'campos.usouFraldas' => ['required', 'string'],
            'campos.ateQueIdadeMamadeira' => ['required', 'string'],
            'campos.desenvolvimentoFalaAndar' => ['required', 'string'],
            'campos.IndicacoesVacinacao' => ['required', 'string'],
            'campos.fazUsoMedicamento' => ['required', 'string'],
            'campos.seletividadeRestricaoAlimentar' => ['required', 'string'],
            'campos.internamentosCirurgias' => ['required', 'string'],
            'campos.deficienciaTranstornos' => ['required', 'string'],
            'campos.acompanhamentoSaudeExterno' => ['required', 'string'],

            'campos.nomeFisioterapeuta' => ['nullable', 'string', 'max:255'],
            'campos.contatoFisioterapeuta' => ['nullable', 'string', 'max:50'],
            'campos.nomeFonoaudiologo' => ['nullable', 'string', 'max:255'],
            'campos.contatoFonoaudiologo' => ['nullable', 'string', 'max:50'],
            'campos.nomePsicologo' => ['nullable', 'string', 'max:255'],
            'campos.contatoPsicologo' => ['nullable', 'string', 'max:50'],
            'campos.nomeNeurologista' => ['nullable', 'string', 'max:255'],
            'campos.contatoNeurologista' => ['nullable', 'string', 'max:50'],

            'campos.rotinaDiaria' => ['required', 'string'],
            'campos.timido' => ['required', 'string'],
            'campos.extrovertido' => ['required', 'string'],
            'campos.persistente' => ['required', 'string'],
            'campos.calmo' => ['required', 'string'],
            'campos.agitado' => ['required', 'string'],
            'campos.ansioso' => ['required', 'string'],
            'campos.organizado' => ['required', 'string'],
            'campos.perfeccionista' => ['required', 'string'],
            'campos.responsavel' => ['required', 'string'],
            'campos.amoroso' => ['required', 'string'],
            'campos.nervoso' => ['required', 'string'],
            'campos.inseguro' => ['required', 'string'],

            'campos.origemHistorico' => ['required', 'string'],
            'campos.artefatosMobilidade' => ['required', 'string'],
            'campos.adaptacaoMobiliario' => ['required', 'string'],
            'campos.necessidadeLocacao' => ['required', 'string'],
            'campos.adaptacaoComputador' => ['required', 'string'],
            'campos.transporteCampus' => ['required', 'string'],
            'campos.atendimentoEducativo' => ['required', 'string'],
            'campos.necessidadeAdaptacaoCurricular' => ['required', 'string'],
            'campos.sistemaLinguistico' => ['required', 'string'],
            'campos.recursosAcessibilidade' => ['required', 'string'],
            'campos.recursosProvidenciados' => ['required', 'string'],
            'campos.outrasNecessidades' => ['required', 'string'],
            'campos.outrasNecessidadesEscolares' => ['nullable', 'string'],
            'campos.sugestoesAdaptacao' => ['nullable', 'string'],
            'campos.potencialidades' => ['required', 'string'],
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
            'campos.acompanhamento' => ['required', 'string'],
            'campos.observacoes' => ['nullable', 'string'],
            'campos.outros' => ['nullable', 'string'],
        ];
    }
}

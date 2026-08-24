<?php

namespace App\Http\Requests;

use App\Models\EntrevistaFamiliar;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EntrevistaFamiliarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $entrevista = $this->route('estudantes.entrevistas-familiares');

        return [
            'user_id' => ['required','integer','exists:users,id'],
            'estudante_id' => ['required','integer','exists:estudantes,id'],
            'data' => ['required','date'],
            'campos.nomeCompleto' => ['required','string'],
            'campos.nomeSocial' => ['required','string'],
            'campos.dataNascimento' => ['required','date'],
            'campos.nomeMae' => ['required','string'],
            'campos.nomePai' => ['required','string'],
            'campos.nomeResponsavel' => ['required','string'],
            'campos.celularEstudante' => ['nullable','string'],
            'campos.celularMae' => ['nullable','string'],
            'campos.celularPai' => ['nullable','string'],
            'campos.celularFixo' => ['nullable','string'],
            'campos.emailEstudante' => ['nullable','email'],
            'campos.emailMae' => ['nullable','email'],
            'campos.emailPai' => ['nullable','email'],
            'campos.emailResponsavel' => ['nullable','email'],
            'campos.podeSerChamadoSAMU' => ['required','string'],
            'campos.nomeCurso' => ['required','string'],
            'campos.formaOferta' => ['required','string'],
            'campos.matricula' => ['nullable','string'],
            'campos.anoPeriodo' => ['required','string'],
            'campos.cota' => ['required','string'],
            'campos.formacaoMae' => ['required','string'],
            'campos.profissaoMae' => ['required','string'],
            'campos.idadeMae' => ['required','string'],
            'campos.maeEmpregada' => ['required','string'],
            'campos.formacaoPai' => ['required','string'],
            'campos.profissaoPai' => ['required','string'],
            'campos.idadePai' => ['required','string'],
            'campos.paiEmpregado' => ['required','string'],
            'campos.formacaoResponsavel' => ['required','string'],
            'campos.profissaoResponsavel' => ['required','string'],
            'campos.idadeResponsavel' => ['required','string'],
            'campos.responsavelEmpregado' => ['required','string'],
            'campos.numeroIrmaos' => ['required','string'],
            'campos.moraCom' => ['required','string'],
            'campos.paisSeparados' => ['required','string'],
            'campos.deficiencia' => ['required','string'],
            'campos.tipoDeficiencia' => ['nullable','string'],
            'campos.rotinaDiaria' => ['required','string'],
            'campos.relacionamentoFamiliares' => ['required','string'],
            'campos.comQuemConvive' => ['required','string'],
            'campos.mantemAmizades' => ['required','string'],
            'campos.atividadesLazer' => ['required','string'],
            'campos.condicoesMoradia' => ['required','string'],
            'campos.ambienteEstudo' => ['required','string'],
            'campos.acompanhamento' => ['required','string'],
            'campos.localPermanencia' => ['required','string'],
            'campos.escolaOrigem' => ['required','string'],
            'campoos.tempoIFPR' => ['required','string'],
            'campos.reprovacao' => ['required','string'],
            'campos.areasFaciliade' => ['required','string'],
            'campos.areasDificuldade' => ['required','string'],
            'campos.trajetoriaEscolar' => ['required','string'],
            'campos.frequentouEducacaoInfantil' => ['required','string'],
            'campos.aprendeuLerEscrever' => ['required','string'],
            'campos.cursosExtraEscolares' => ['required','string'],
            'campos.atendimentoEduacionalEspecializado' => ['required','string'],
            'campos.adaptacaoCurricular' => ['required','string'],
            'campos.outrasNecessidades' => ['required','string'],
            'campos.potencialidades' => ['required','string'],
            'campos.gestacaoPlanejada' => ['required','string'],
            'campos.fezPreNatal' => ['required','string'],
            'campos.doencasApresentadas' => ['required','string'],
            'campos.usouFraldas' => ['required','string'],
            'campos.ateQueIdadeMamadeira' => ['required','string'],
            'campos.desenvolvimentoFalaAndar' => ['required','string'],
            'campos.IndicacoesVacinacao' => ['required','string'],
            'campos.fazUsoMedicamento' => ['required','string'],
            'campos.seletividadeRestricaoAlimentar' => ['required','string'],
            'campos.internamentosCirurgias' => ['required','string'],
            'campos.deficienciaTranstornos' => ['required','string'],
            'campos.acompanhamentoSaudeExterno' => ['required','string'],
            'campos.nomeFisioterapeuta' => ['required','string'],
            'campos.contatoFisioterapeuta' => ['required','string'],
            'campos.nomeFonoaudiologo' => ['required','string'],
            'campos.contatoFonoaudiologo' => ['required','string'],
            'campos.nomePsicologo' => ['required','string'],
            'campos.contatoPsicologo' => ['required','string'],
            'campos.nomeNeurologista' => ['required','string'],
            'campos.contatoNeurologista' => ['required','string'],
            'campos.observacoes' => ['nullable','string'],
            'campos.timido' => ['required','string'],
            'campos.extrovertido' => ['required','string'],
            'campos.persistente' => ['required','string'],
            'campos.calmo' => ['required','string'],
            'campos.agitado' => ['required','string'],
            'campos.ansioso' => ['required','string'],
            'campos.organizado' => ['required','string'],
            'campos.perfeccionista' => ['required','string'],
            'campos.resposanvel' => ['required','string'],
            'campos.amoroso' => ['required','string'],
            'campos.nervoso' => ['required','string'],
            'campos.inseguro' => ['required','string'],
            'campos.outros' => ['nullable','string'],
            'campos.origemHistorico' => ['required','string'],
            'campos.artefatosMobilidade' => ['required','string'],
            'campos.adaptacaoMobiliario' => ['required','string'],
            'campos.necessidadeLocacao' => ['required','string'],
            'campos.adaptacaoComputador' => ['required','string'],
            'campos.transporteCampus' => ['required','string'],
            'campos.atendimentoEducativo' => ['required','string'],
            'campos.necessidadeAdaptacaoCurricular' => ['required','string'],
            'campos.sistemaLinguistico' => ['required','string'],
            'campos.recursosAcessibilidade' => ['required','string'],
            'campos.recursosProvidenciados' => ['required','string'],
            'campos.outrasNecessidadesEscolares' => ['nullable','string'],
            'campos.sugestoesAdaptacao' => ['nullable','string'],
            'campos.acompanhamentoAEE' => ['required','string'],
            'campos.potencialidadesDificuldades' => ['required','string'],
            'campos.materialAdaptado' => ['required','string'],
            'campos.apoioEscolar' => ['required','string'],
            'campos.comportamentoDiferenciado' => ['required','string'],
            'campos.questaoSensibilidade' => ['required','string'],
            'campos.momentoCrise' => ['required','string'],
            'campos.laudoEscola' => ['required','string'],
            'campos.inicioTratamento' => ['required','string'],
            'campos.porQueComecou' => ['required','string'],
            'campos.apresentaCrisesComportamento' => ['required','string'],
            'campos.qualSituacoesDesencadeiamCrises' => ['required','string'],
            'campos.orientacoesEvitarEstresse' => ['required','string'],
            'campos.quaisMelhorias' => ['required','string'],
            'campos.maioresOrientacoes' => ['required','string'],
            'campos.necessitaAbafadorSom' => ['required','string'],
            'campos.comoSeOrganiza' => ['required','string'],
            'campos.comoAprende' => ['required','string'],
            'campos.quaisRecursosFacilitam' => ['required','string'],
            'campos.quaisRecursosDificultam' => ['required','string'],
            'campos.emQueAreaFacilidade' => ['required','string'],
            'campos.emQueAreaDificuldade' => ['required','string']
        ];
    }
}

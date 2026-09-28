<?php

namespace App\Http\Requests;

use App\Enums\StatusPlanoTrabalhoEnum;
use App\Enums\TipoFormularioEnum;
use App\Models\Disciplina;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PlanoTrabalhoEstudanteRequest extends FormRequest
{
    use ComCamposAdicionais;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
        $this->prepararCampos();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(StatusPlanoTrabalhoEnum::class)],
            'periodo_inicio' => ['sometimes', 'required', 'date'],
            'periodo_fim' => ['sometimes', 'required', 'date', 'after_or_equal:periodo_inicio'],
            'estudante_id' => ['required_if:status,PENDENTE', 'exists:estudantes,id'],
            'user_id' => ['sometimes', 'required', 'exists:users,id'],

            'disciplinas' => ['required_with:estudante_id', 'array'],
            'disciplinas.*' => ['required_with:estudante_id', 'exists:disciplinas,id'],

            'professores' => ['required_with:disciplinas', 'array'],
            'professores.*' => ['required_with:disciplinas', 'exists:users,id'],

            ...$this->regrasCamposAdicionais($this->chavesPermitidas()),

            'chosenDisciplina' => ['sometimes', 'nullable', 'exists:disciplinas,id'],
            'previewDisciplinas' => ['sometimes', 'nullable', 'array'],
            'previewDisciplinas.*' => ['sometimes', 'exists:disciplinas,id']
        ];
    }

    public function attributes(): array
    {
        return $this->rotulosCamposAdicionais();
    }

    private function chavesPermitidas(): array
    {
        $registro = $this->route('planoTrabalho');
        $registro = $registro instanceof PlanoTrabalhoEstudante ? $registro : null;

        return $this->chavesPermitidasPara(
            TipoFormularioEnum::PLANO_TRABALHO,
            $registro,
            $registro?->estudante_id ?? $this->input('estudante_id'),
        );
    }

    public function after(): array
    {
        return [
            function ($validator) {
                if ($this->input('estudante_id') === null) return;

                $disciplinasIds = $this->input('disciplinas', []);
                $professoresIds = $this->input('professores', []);
                $disciplinas = Disciplina::whereIn('id', $disciplinasIds)->get()->keyBy('id');
                $professores = User::with('disciplinas')->whereIn('id', $professoresIds)->get();

                foreach($disciplinasIds as $disciplinaId) {
                    $matchingProfessores = $professores->filter(fn($professor) => $professor->disciplinas->contains('id', $disciplinaId));

                    if ($matchingProfessores->count() === 0)
                        $validator->errors()->add('professores', 'O componente ' . $disciplinas[$disciplinaId]->nome . ' não possui um professor selecionado');

                    if ($matchingProfessores->count() > 1)
                        $validator->errors()->add('professores', 'O componente ' . $disciplinas[$disciplinaId]->nome . ' possui mais de um professor selecionado');
                }

                $chosenDisciplina = $this->input('chosenDisciplina');
                $previewDisciplinas = $this->input('previewDisciplinas', []);

                if ($chosenDisciplina !== null && !in_array($chosenDisciplina, $previewDisciplinas))
                    $validator->errors()->add('chosenDisciplina', 'O componente selecionado não faz parte desta pré-visualização');
            }
        ];
    }
}

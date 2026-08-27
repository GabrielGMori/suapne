<?php

namespace App\Http\Requests;

use App\Enums\EtniaEnum;
use App\Enums\SexoEnum;
use App\Enums\SituacaoEstudanteEnum;
use App\Models\Estudante;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EstudanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),

            'telefone' => preg_replace('/\D/', '', $this->telefone),
            'telefone_pai' => preg_replace('/\D/', '', $this->telefone_pai),
            'telefone_mae' => preg_replace('/\D/', '', $this->telefone_mae),
            'telefone_responsavel' => preg_replace('/\D/', '', $this->telefone_responsavel),
        ]);
    }

    public function rules(): array
    {
        $estudante = $this->route('estudante');

        return [
            'nome' => ['required', 'string', 'max:200'],
            'matricula' => ['required', 'string', 'max:50', Rule::unique('estudantes', 'matricula')->ignore($estudante?->id)],
            'ingresso_ano' => ['required', 'integer', 'digits:4'],
            'ingresso_periodo' => ['required', 'integer', 'digits:1'],
            'periodo' => ['required', 'integer', 'digits:1'],
            'email_pessoal' => ['nullable', 'email', 'max:255'],
            'email_academico' => ['required', 'email', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'telefone' => ['nullable', 'string', 'min:10', 'max:20'],
            'necessidades' => ['nullable', 'string'],
            'cpf' => ['required', 'string', 'size:11', Rule::unique('estudantes', 'cpf')->ignore($estudante?->id)],
            'situacao' => ['required', Rule::enum(SituacaoEstudanteEnum::class)],
            'sexo' => ['required', Rule::enum(SexoEnum::class)],
            'etnia' => ['nullable', Rule::enum(EtniaEnum::class)],
            'nacionalidade' => ['nullable', 'string', 'max:45'],
            'naturalidade' => ['nullable', 'string', 'max:45'],
            'nome_pai' => ['nullable', 'string', 'max:200'],
            'telefone_pai' => ['nullable', 'string', 'min:10', 'max:20'],
            'nome_mae' => ['nullable', 'string', 'max:200'],
            'telefone_mae' => ['nullable', 'string', 'min:10', 'max:20'],
            'nome_responsavel' => ['nullable', 'string', 'max:200'],
            'telefone_responsavel' => ['nullable', 'string', 'min:10', 'max:20'],
            'email_responsavel' => ['nullable', 'email', 'max:255'],
            'avatar' => ['nullable', 'string', 'max:255'],

            'curso_id' => ['required', 'integer', 'exists:cursos,id'],
        ];
    }
}

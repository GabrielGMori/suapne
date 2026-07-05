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

class StoreEstudanteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Estudante::class);
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:200'],
            'matricula' => ['required', 'string', 'max:50', 'unique:estudantes,matricula'],
            'ingresso_ano' => ['required', 'integer', 'digits:4'],
            'ingresso_periodo' => ['required', 'integer', 'digits:1'],
            'periodo' => ['required', 'integer', 'digits:1'],
            'email_pessoal' => ['nullable', 'email', 'max:255'],
            'email_academico' => ['required', 'email', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'telefone' => ['nullable', 'string', 'size:20'],
            'necessidades' => ['nullable', 'string'],
            'cpf' => ['required', 'string', 'size:11', 'unique:estudantes,cpf'],
            'situacao' => ['required', Rule::enum(SituacaoEstudanteEnum::class)],
            'sexo' => ['required', Rule::enum(SexoEnum::class)],
            'etnia' => ['nullable', Rule::enum(EtniaEnum::class)],
            'nacionalidade' => ['nullable', 'string', 'max:45'],
            'naturalidade' => ['nullable', 'string', 'max:45'],
            'nome_pai' => ['nullable', 'string', 'max:200'],
            'telefone_pai' => ['nullable', 'string', 'size:20'],
            'nome_mae' => ['nullable', 'string', 'max:200'],
            'telefone_mae' => ['nullable', 'string', 'size:20'],
            'nome_responsavel' => ['nullable', 'string', 'max:200'],
            'telefone_responsavel' => ['nullable', 'string', 'size:20'],
            'email_responsavel' => ['nullable', 'email', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:10240'],

            'curso_id' => ['required', 'integer', 'exists:cursos,id'],
        ];
    }
}

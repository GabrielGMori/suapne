<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DocumentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $planosFlexibilizacao = $this->route('planos-flexibilizacao');

        return [
            'documentos' => ['required', 'array', 'min:1'],
            'documentos.*.nome' => ['required', 'string', 'max:255'],
            'documentos.*.path' => ['required', 'string'],
            'documentos.*.extensao' => ['required', 'string'],
        ];
    }
}

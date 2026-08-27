<?php

namespace App\Http\Controllers;
use App\Models\Documento;
use App\Models\Estudante;
use App\Enums\TipoDocumentoEnum;
use App\Http\Requests\DocumentoRequest;
use Auth;

class DocumentoController extends Controller
{
    public function create(Estudante $estudante, string $tipoDocumento = 'documento')
    {
        return view('estudantes.create-documento', ['estudante' => $estudante, 'tipo' => strtoupper($tipoDocumento)]);
    }

    public function store(DocumentoRequest $request, Estudante $estudante, TipoDocumentoEnum $tipoDocumento)
    {
        $documentos = $request->validated('documentos');

        foreach ($documentos as $doc) {
            Documento::create([
                'nome' => $doc['nome'],
                'extensao' => $doc['extensao'],
                'path' => $doc['path'],
                'tipo' => $tipoDocumento,
                'user_id' => Auth::id(),
                'estudante_id' => $estudante->id,
            ]);
        }

        return redirect()
            ->route('estudantes.show', ['estudante' => $estudante])
            ->with('status', 'Documentos salvos com sucesso.');
    }
}

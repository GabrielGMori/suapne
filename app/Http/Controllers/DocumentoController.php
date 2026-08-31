<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Estudante;
use App\Enums\TipoDocumentoEnum;
use App\Http\Requests\DocumentoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function create(Request $request, Estudante $estudante, string $tipoDocumento = 'documento')
    {
        abort_unless($request->user()->can('create', Documento::class), 404);

        return view('estudantes.create-documento', ['estudante' => $estudante, 'tipo' => strtoupper($tipoDocumento)]);
    }

    public function store(DocumentoRequest $request, Estudante $estudante, TipoDocumentoEnum $tipoDocumento) : RedirectResponse
    {
        abort_unless($request->user()->can('create', Documento::class), 404);

        $documentos = $request->validated('documentos');

        foreach ($documentos as $doc) {
            Documento::create([
                'nome_arquivo' => $doc['nome_arquivo'],
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

    public function destroy(Request $request, Estudante $estudante, Documento $documento): RedirectResponse
    {
        abort_unless($request->user()->can('delete', $documento), 404);

        $documento->delete();

        return redirect()
            ->route('estudantes.show', ['estudante' => $estudante])
            ->with('status', 'Documento excluído com sucesso.');
    }
}

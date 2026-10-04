<?php

namespace App\Http\Controllers;

use App\Enums\TipoFormularioEnum;
use App\Http\Requests\TemplateFormularioRequest;
use App\Models\TemplateFormulario;
use App\Support\CamposTemplate;
use Illuminate\Http\Request;

class TemplateFormularioController extends Controller
{
    public function index(Request $request)
    {
        abort_unless($request->user()->can('viewAny', TemplateFormulario::class), 404);

        return view('templates.index');
    }

    public function tipo(Request $request, TipoFormularioEnum $tipo)
    {
        abort_unless($request->user()->can('viewAny', TemplateFormulario::class), 404);

        return view('templates.tipo', [
            'tipo' => $tipo,
            'templates' => TemplateFormulario::with('user')->doTipo($tipo)->latest()->get(),
        ]);
    }

    public function create(Request $request, TipoFormularioEnum $tipo)
    {
        abort_unless($request->user()->can('create', TemplateFormulario::class), 404);

        return view('templates.form', [
            'tipo' => $tipo,
            'template' => new TemplateFormulario([
                'nome' => '',
                'tipo' => $tipo,
                'campos' => CamposTemplate::campos($tipo),
            ]),
        ]);
    }

    public function store(TemplateFormularioRequest $request, TipoFormularioEnum $tipo)
    {
        abort_unless($request->user()->can('create', TemplateFormulario::class), 404);

        TemplateFormulario::create([
            ...$request->validated(),
            'tipo' => $tipo,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('templates.tipo', ['tipo' => $tipo])
            ->with('status', 'Template criado com sucesso!');
    }

    public function edit(Request $request, TemplateFormulario $templateFormulario)
    {
        abort_unless($request->user()->can('update', $templateFormulario), 404);

        return view('templates.form', [
            'tipo' => $templateFormulario->tipo,
            'template' => $templateFormulario,
        ]);
    }

    public function update(TemplateFormularioRequest $request, TemplateFormulario $templateFormulario)
    {
        abort_unless($request->user()->can('update', $templateFormulario), 404);

        $templateFormulario->update($request->validated());

        return redirect()->route('templates.tipo', ['tipo' => $templateFormulario->tipo])
            ->with('status', 'Template atualizado com sucesso!');
    }

    public function destroy(Request $request, TemplateFormulario $templateFormulario)
    {
        abort_unless($request->user()->can('delete', $templateFormulario), 404);

        $tipo = $templateFormulario->tipo;
        $templateFormulario->delete();

        return redirect()->route('templates.tipo', ['tipo' => $tipo])
            ->with('status', 'Template excluído com sucesso!');
    }
}

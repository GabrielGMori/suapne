<?php

namespace App\Models;

use App\Enums\TipoFormularioEnum;
use App\Support\FormularioPadrao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class ModeloFormulario extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait;

    protected $table = 'modelos_formulario';

    protected $fillable = [
        'tipo',
        'removidos',
        'personalizados',
        'estudante_id',
        'user_id',
    ];

    protected $casts = [
        'tipo' => TipoFormularioEnum::class,
        'removidos' => 'array',
        'personalizados' => 'array',
    ];

    public function estudante(): BelongsTo
    {
        return $this->belongsTo(Estudante::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function para(TipoFormularioEnum $tipo, ?int $estudanteId): static
    {
        $modelo = $estudanteId
            ? static::query()->where('tipo', $tipo)->where('estudante_id', $estudanteId)->first()
            : null;

        return $modelo ?? new static([
            'tipo' => $tipo,
            'estudante_id' => $estudanteId,
            'removidos' => [],
            'personalizados' => [],
        ]);
    }

    public function campos(): array
    {
        $removidos = $this->removidos ?? [];

        $padrao = array_filter(
            FormularioPadrao::camposAdicionais($this->tipo),
            fn($campo) => !in_array($campo['chave'], $removidos, true)
        );

        $personalizados = array_map(
            fn($campo) => [...$campo, 'ordem' => $campo['ordem'] ?? FormularioPadrao::ORDEM_PERSONALIZADO],
            $this->personalizados ?? []
        );

        $campos = [...$padrao, ...$personalizados];
        usort($campos, fn($a, $b) => $a['ordem'] <=> $b['ordem']);

        return array_values($campos);
    }

    public function chaves(): array
    {
        return array_column($this->campos(), 'chave');
    }

    public function campo(string $chave): ?array
    {
        foreach ($this->campos() as $campo) {
            if ($campo['chave'] === $chave) {
                return $campo;
            }
        }

        return null;
    }

    public function adicionar(string $rotulo, string $tipo, bool $obrigatorio): array
    {
        $campo = FormularioPadrao::novoCampo($rotulo, $tipo, $obrigatorio, $this->campos());

        $this->personalizados = [...($this->personalizados ?? []), $campo];
        $this->salvarComoAutor();

        return $campo;
    }

    public function remover(string $chave): void
    {
        $chavesPadrao = array_column(FormularioPadrao::camposAdicionais($this->tipo), 'chave');

        if (in_array($chave, $chavesPadrao, true)) {
            $this->removidos = array_values(array_unique([...($this->removidos ?? []), $chave]));
        } else {
            $this->personalizados = array_values(array_filter($this->personalizados ?? [], fn($campo) => $campo['chave'] !== $chave));
        }

        $this->salvarComoAutor();
    }

    public function restaurarPadrao(): void
    {
        $this->removidos = [];
        $this->personalizados = [];
        $this->salvarComoAutor();
    }

    public function ehPadrao(): bool
    {
        return empty($this->removidos) && empty($this->personalizados);
    }

    private function salvarComoAutor(): void
    {
        $this->user_id = Auth::id() ?? $this->user_id;
        $this->save();
    }

    public function getNomeAttribute(): string
    {
        return "{$this->tipo->label()} - {$this->estudante?->nome}";
    }
}

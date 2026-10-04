<?php

namespace App\Models;

use App\Enums\TipoFormularioEnum;
use App\Support\CamposTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class TemplateFormulario extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait;

    protected $table = 'templates_formulario';

    protected $fillable = [
        'nome',
        'tipo',
        'campos',
        'padrao',
        'user_id',
    ];

    protected $casts = [
        'tipo' => TipoFormularioEnum::class,
        'campos' => 'array',
        'padrao' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function estudantes(): BelongsToMany
    {
        return $this->belongsToMany(Estudante::class, 'estudante_template_formulario');
    }

    public static function padraoDe(TipoFormularioEnum $tipo): static
    {
        return static::query()->where('tipo', $tipo)->where('padrao', true)->first()
            ?? new static([
                'nome' => 'Template padrão',
                'tipo' => $tipo,
                'campos' => CamposTemplate::campos($tipo),
                'padrao' => true,
            ]);
    }

    public static function doEstudante(TipoFormularioEnum $tipo, ?int $estudanteId): static
    {
        $template = $estudanteId
            ? static::query()
                ->where('tipo', $tipo)
                ->whereHas('estudantes', fn($q) => $q->where('estudantes.id', $estudanteId))
                ->first()
            : null;

        return $template ?? static::padraoDe($tipo);
    }

    public function associarEstudantes(array $estudanteIds): void
    {
        $this->estudantes()->sync($estudanteIds);
    }

    public static function doEstudanteTodos(TipoFormularioEnum $tipo, ?int $estudanteId)
    {
        if (!$estudanteId) {
            return collect();
        }

        return static::query()
            ->where('tipo', $tipo)
            ->whereHas('estudantes', fn($q) => $q->where('estudantes.id', $estudanteId))
            ->orderBy('nome')
            ->get();
    }

    public function chaves(): array
    {
        return array_column($this->campos ?? [], 'chave');
    }

    public function campo(string $chave): ?array
    {
        foreach ($this->campos ?? [] as $campo) {
            if ($campo['chave'] === $chave) {
                return $campo;
            }
        }

        return null;
    }

    public function camposFixos(): array
    {
        return array_values(array_filter($this->campos ?? [], fn($campo) => $campo['fixo'] ?? false));
    }

    public function getQuantidadeCamposAttribute(): int
    {
        return count($this->campos ?? []);
    }

    public function getNomeCompletoAttribute(): string
    {
        return "{$this->tipo->label()} - {$this->nome}";
    }
}

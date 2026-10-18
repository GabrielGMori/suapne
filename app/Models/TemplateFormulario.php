<?php

namespace App\Models;

use App\Enums\TipoFormularioEnum;
use App\Support\CamposTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function scopeDoTipo(Builder $query, TipoFormularioEnum $tipo): Builder
    {
        return $query->where('tipo', $tipo);
    }

    public static function padraoDe(TipoFormularioEnum $tipo): static
    {
        return static::query()->doTipo($tipo)->where('padrao', true)->first()
            ?? new static([
                'nome' => 'Template padrão',
                'tipo' => $tipo,
                'campos' => CamposTemplate::campos($tipo),
                'padrao' => true,
            ]);
    }

    public static function opcoesDe(TipoFormularioEnum $tipo): array
    {
        return static::query()->doTipo($tipo)->orderByDesc('padrao')->orderBy('nome')
            ->pluck('nome', 'id')
            ->mapWithKeys(fn($nome, $id) => [(string) $id => $nome])
            ->toArray();
    }

    public function getCriadoPorAttribute(): ?string
    {
        return $this->padrao ? 'Automático' : $this->user?->nome;
    }

    public function getQuantidadeCamposAttribute(): int
    {
        return count($this->campos ?? []);
    }
}

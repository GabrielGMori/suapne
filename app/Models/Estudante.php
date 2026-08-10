<?php

namespace App\Models;

use App\Enums\EtniaEnum;
use App\Enums\SexoEnum;
use App\Enums\SituacaoEstudanteEnum;
use App\Enums\TipoDocumentoEnum;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Estudante extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = [
        'nome',
        'matricula',
        'ingresso_ano',
        'ingresso_periodo',
        'periodo',
        'email_pessoal',
        'email_academico',
        'data_nascimento',
        'telefone',
        'necessidades',
        'cpf',
        'situacao',
        'sexo',
        'etnia',
        'nacionalidade',
        'naturalidade',
        'nome_pai',
        'telefone_pai',
        'nome_mae',
        'telefone_mae',
        'nome_responsavel',
        'telefone_responsavel',
        'email_responsavel',
        'curso_id',
        'avatar',
    ];

    protected array $readableFillable = [
        'nome' => 'Nome',
        'matricula' => 'Matrícula',
        'ingresso_ano' => 'Ano de ingresso',
        'ingresso_periodo' => 'Período de ingresso',
        'periodo' => 'Período atual',
        'email_pessoal' => 'Email pessoal',
        'email_academico' => 'Email acadêmico',
        'data_nascimento' => 'Data de nascimento',
        'telefone' => 'Telefone',
        'necessidades' => 'Necessidades',
        'cpf' => 'CPF',
        'situacao' => 'Situação',
        'sexo' => 'Sexo',
        'etnia' => 'Etnia',
        'nacionalidade' => 'Nacionalidade',
        'naturalidade' => 'Naturalidade',
        'nome_pai' => 'Nome do pai',
        'telefone_pai' => 'Telefone do pai',
        'nome_mae' => 'Nome da mãe',
        'telefone_mae' => 'Telefone da mãe',
        'nome_responsavel' => 'Nome do responsável',
        'telefone_responsavel' => 'Telefone do responsável',
        'email_responsavel' => 'Email do responsável',
        'curso_id' => 'Curso',
    ];

    protected $cascadeSofDeleteRelations = [
        'planosFlexibilizacaoCurricular',
        'planosTrabalho',
        'atendimentosSemanais',
        'documentos',
        'entrevistaFamiliar',
        'observacoes',
    ];

    protected $casts = [
        'ingresso_ano' => 'integer',
        'ingresso_periodo' => 'integer',
        'periodo' => 'integer',
        'data_nascimento' => 'date',
        'situacao' => SituacaoEstudanteEnum::class,
        'sexo' => SexoEnum::class,
        'etnia' => EtniaEnum::class,
    ];

    public function getReadableFillable(string $key): ?string
    {
        return $this->readableFillable[$key] ?? null;
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function planosFlexibilizacaoCurricular(): HasMany
    {
        return $this->hasMany(PlanoFlexibilizacaoCurricular::class, 'estudante_id');
    }

    public function planosTrabalho(): HasMany
    {
        return $this->hasMany(PlanoTrabalhoEstudante::class, 'estudante_id');
    }

    public function atendimentosSemanais(): HasMany
    {
        return $this->hasMany(AtendimentoSemanal::class, 'estudante_id');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class, 'estudante_id');
    }

    public function entrevistaFamiliar(): HasOne
    {
        return $this->hasOne(EntrevistaFamiliar::class, 'estudante_id');
    }

    public function observacoes(): HasMany
    {
        return $this->hasMany(ObservacaoEstudante::class, 'estudante_id');
    }
    public function getEntrevistaEstudanteAttribute(): ?Documento
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::ENTREVISTA_ESTUDANTE)->first();
    }
    public function getLaudoAttribute(): ?Documento
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::LAUDO)->first();
    }

    public function getEstudoDeCasoAttribute(): ?Documento
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::ESTUDO_DE_CASO)->first();
    }

    public function getFichaCpaeAttribute(): ?Documento
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::FICHA_CPAE)->first();
    }

    public function getOutrosDocumentosAttribute(): Documento|Collection
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::DOCUMENTO)->get();
    }

    public function getIdadeAttribute(): int
    {
        return now()->diff($this->data_nascimento)->y;
    }
}

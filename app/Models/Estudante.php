<?php

namespace App\Models;

use App\Enums\TipoDocumentoEnum;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Curso;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\Models\PlanoTrabalhoEstudante;
use App\Models\AtendimentoSemanal;
use App\Models\Documento;
use App\Models\EntrevistaFamiliar;
use App\Models\ObservacaoEstudante;
class Estudante extends Model
{
    use HasFactory;

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

    protected $readableFillable = [
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

    protected $casts = [
        'ingresso_ano' => 'integer',
        'ingresso_periodo' => 'integer',
        'periodo' => 'integer',
        'data_nascimento' => 'date',
        'situacao' => \App\Enums\SituacaoEstudanteEnum::class,
        'sexo' => \App\Enums\SexoEnum::class,
        'etnia' => \App\Enums\EtniaEnum::class,
    ];

    public function getReadableFillable(string $key): ?string
    {
        return $this->readableFillable[$key] ?? null;
    }

    public function getAvatarAttribute($value)
    {
        return $value ?: ('https://api.dicebear.com/7.x/adventurer/svg?backgroundColor=b6e3f4&seed=' . urlencode($this->matricula ?? 'user'));
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function planosFlexibilizacaoCurricular()
{
    return $this->hasMany(PlanoFlexibilizacaoCurricular::class, 'estudante_id');
}

    public function planosTrabalho()
    {
        return $this->hasMany(PlanoTrabalhoEstudante::class, 'estudante_id');
    }

    public function atendimentosSemanais()
    {
        return $this->hasMany(AtendimentoSemanal::class, 'estudante_id');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'estudante_id');
    }

    public function entrevistaFamiliar()
    {
        return $this->hasOne(EntrevistaFamiliar::class, 'estudante_id');
    }

    public function observacoes()
    {
        return $this->hasMany(ObservacaoEstudante::class, 'estudante_id');
    }
    public function getEntrevistaEstudanteAttribute()
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::ENTREVISTA_ESTUDANTE)->first();
    }
    public function getLaudoAttribute()
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::LAUDO)->first();
    }

    public function getEstudoDeCasoAttribute()
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::ESTUDO_DE_CASO)->first();
    }

    public function getFichaCpaeAttribute()
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::FICHA_CPAE)->first();
    }

    public function getOutrosDocumentosAttribute()
    {
        return $this->documentos()->where('tipo', TipoDocumentoEnum::DOCUMENTO)->get();
    }

    public function getIdadeAttribute() : int
    {
        return now()->diff($this->data_nascimento)->y;
    }
}

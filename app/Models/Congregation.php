<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congregation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_principal',
        'nomes_alternativos',
        'siglas',
        'familia_final',
        'genero',
        'datas_aprovacao',
        'anos_reformulacao',
        'situacao_canonica',
        'data_fundacao',
        'pais_fundacao',
        'cidade_fundacao',
        'chegada_brasil_estado',
        'chegada_brasil_municipio',
        'membros_brasil',
        'irmaos',
        'postulantes',
        'novicos',
        'carisma',
        'motivos_vinda',
        'descricao',
        'ano_fundacao'
    ];

    public function sources()
    {
        return $this->belongsToMany(Source::class, 'congregation_source', 'congregation_id', 'source_id');
    }
    
}
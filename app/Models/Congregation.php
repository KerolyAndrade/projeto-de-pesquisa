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
        'fontes',
        'data_aprovacao_constituicoes',
        'data_aprovacao_regras',
        'data_aprovacao_dir_diocesano',
        'data_aprovacao_dir_pontificio',
        'data_aprovacao_decretum_laudis',
        'anos_reformulacao_constituicoes',
        'situacao_canonica',
        'data_fundacao',
        'pais_fundacao',
        'cidade_fundacao',
        'chegada_brasil_estado',
        'chegada_brasil_municipio',
        'membros_brasil',
        'irmaos_as',
        'postulantes',
        'novicos',
        'carisma',
        'motivos_vinda',
    ];
}


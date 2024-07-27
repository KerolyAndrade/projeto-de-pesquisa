<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congregation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome_principal',
        'nomes_alternativos',
        'siglas',
        'familia_final',
        'genero',
        'fontes',
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
    ];

    // Métodos, relações e outros atributos conforme necessário
}

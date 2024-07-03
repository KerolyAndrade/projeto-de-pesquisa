<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congregation extends Model
{
    use HasFactory;

    protected $table = 'congregations';

    protected $fillable = [
        'fontes',
        'familia_final',
        'nome_principal',
        'nomes_alternativos',
        'siglas',
        'pais_fundacao',
        'pais_presente', // Adicione esta linha
        'estados_presente', // Adicione esta linha
        'ano_fundacao',
        'ano_chegada',
        // Adicione outras colunas conforme necessário
    ];
    
}

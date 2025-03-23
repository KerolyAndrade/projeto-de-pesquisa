<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatisfactionSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'instituicao',
        'finalidade',
        'experiencia',
        'sugestoes',
        'informacoes_congregacao',
        'anexo',
        'consentimento',
    ];
}

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
        // Adicione outras colunas conforme necessário
    ];

    // Relacionamentos

    // Relacionamento com membros da congregação
    public function membros()
    {
        return $this->hasMany(Membro::class);
    }

    // Relacionamento com o país de fundação
    public function paisFundacao()
    {
        return $this->belongsTo(Pais::class, 'pais_fundacao_id');
    }

    // Relacionamento com o país presente
    public function paisPresente()
    {
        return $this->belongsTo(Pais::class, 'pais_presente_id');
    }

    // Relacionamento com o estado presente
    public function estadoPresente()
    {
        return $this->belongsTo(Estado::class, 'estado_presente_id');
    }
}

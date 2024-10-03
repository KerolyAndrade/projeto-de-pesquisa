<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = ['url'];

    public function congregations()
    {
        return $this->belongsToMany(Congregation::class, 'congregation_source', 'source_id', 'congregation_id');
    }
}


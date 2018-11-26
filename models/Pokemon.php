<?php

namespace Minhapokedex\Models;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokedex';
    
    protected $fillable = [
        'nome',
        'movimentos',
        'imagem',
    ];
}

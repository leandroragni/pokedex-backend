<?php

namespace Minhapokedex\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Minhapokedex\Models\Pokemon;

class PokemonRepository
{
    public function listarPokemonsCapturados()
    {
        return Pokemon::get();
    }
    
    public function adicionar(array $pokemonInfo)
    {
        return Pokemon::firstOrCreate($pokemonInfo);
    }
}
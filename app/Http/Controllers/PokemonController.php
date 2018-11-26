<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Minhapokedex\Services\PokemonService;

class PokemonController extends Controller
{
    private $pokemonService;
    
    public function __construct(PokemonService $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }
    
    public function listarPokemonsDaPokedex()
    {
        return $this->pokemonService->listarPokemonsDaPokedex();
    }
    
    public function encontrePokemon()
    {
        return $this->pokemonService->aparecerPokemon();
    }
    
    public function capturarPokemon($pokemon)
    {
        return [ 
            'data' => $this->pokemonService->capturarPokemon($pokemon),
        ];
    }
}

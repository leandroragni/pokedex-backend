<?php

namespace Minhapokedex\Services;

use Minhapokedex\Models\Pokemon;
use Minhapokedex\Repositories\PokemonRepository;

class PokemonService
{
    private $pokemonApi = 'https://pokeapi.co/api/v2/pokemon/';
    
    private $pokemonRepository;
    
    public function __construct(PokemonRepository $pokemonRepository)
    {
        $this->pokemonRepository = $pokemonRepository;
    }
    
    public function listarPokemonsDaPokedex()
    {
        return $this->pokemonRepository->listarPokemonsCapturados();
    }
    
    public function aparecerPokemon()
    {
        $pokemons = $this->listaDePokemonsDaApi();
        
        $numeroAleatorioDaListaPokemon = $this->obterNumeroAleatorio();
        
        return $this->obterDadosDoPokemon($pokemons[$numeroAleatorioDaListaPokemon]->name);
    }
    
    public function capturarPokemon(string $pokemonNome)
    {
        if ($this->obterChanceDeCaptura()) {
            return $this->persistirPokemonNaPokedex($pokemonNome) ? 'capturado' : 'não capturado';
        }
        
        return 'Não foi possível capturar o pokemon!';
    }
    
    private function listaDePokemonsDaApi()
    {
        $httpClient = $this->getHttpClient();
        
        $request = $httpClient->get($this->pokemonApi);
        $response = $request->getBody()->getContents();
        
        $pokemons = json_decode($response)->results;
        
        return $pokemons;
    }
    
    private function getHttpClient()
    {
        return new \GuzzleHttp\Client();
    }
    
    private function obterNumeroAleatorio(): int
    {
        return rand(0, 948);
    }
    
    private function obterChanceDeCaptura(): bool
    {
        $chanceDeCaptura = rand(1, 100);
        
        return $chanceDeCaptura <= 70 ? true : false;
    }
    
    private function persistirPokemonNaPokedex(string $pokemonNome)
    {
        $pokemon = $this->obterDadosDoPokemon($pokemonNome);
        
        return $this->pokemonRepository->adicionar($pokemon);
    }
    
    private function obterDadosDoPokemon($pokemonNome)
    {
        $httpClient = $this->getHttpClient();
        
        $endpointPokemon = $this->pokemonApi . $pokemonNome;
        
        $request = $httpClient->get($endpointPokemon);
        $response = $request->getBody()->getContents();
        
        $dadosDecoded = json_decode($response);
        
        return [
            'nome' => $dadosDecoded->name,
            'movimentos' => json_encode($dadosDecoded->moves),
            'imagem' => $dadosDecoded->sprites->front_default,
        ];
    }
}
<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    [
        'prefix' => 'pokemon'
    ],
    function () {
        Route::get('/listar/capturados', 'PokemonController@listarPokemonsDaPokedex');
        Route::get('/encontrar', 'PokemonController@encontrePokemon');
        Route::get('/capturar/{pokemon}', 'PokemonController@capturarPokemon');
    }
);



<?php

/*$app->get('/users/list', 'App\Controller\UsersController::listAction')->bind('users.list');
$app->get('/users/edit/{id}', 'App\Controller\UsersController::editAction')->bind('users.edit');
$app->get('/users/new', 'App\Controller\UsersController::newAction')->bind('users.new');
$app->post('/users/delete/{id}', 'App\Controller\UsersController::deleteAction')->bind('users.delete');
$app->post('/users/save', 'App\Controller\UsersController::saveAction')->bind('users.save');*/

//User
$app->get('/users', 'App\Users\Controller\UsersController::getListUserAction')->bind('users.list');
$app->get('/users/{id}', 'App\Users\Controller\UsersController::getUserAction')->bind('users.entity');
$app->post('/users', 'App\Users\Controller\UsersController::insertUserAction')->bind('users.insert');
$app->put('/users', 'App\Users\Controller\UsersController::updateUserAction')->bind('users.update');
$app->put('/users/poke_points', 'App\Users\Controller\UsersController::updatePokePointsUserAction')->bind('users.pokepointsUpdate');
$app->delete('/users/{id}', 'App\Users\Controller\UsersController::deleteUserAction')->bind('users.delete');

//Pokemon
$app->get('/pokemons/page/{page}', 'App\Pokemons\Controller\PokemonsController::getListPokemonAction')->bind('pokemons.list');
$app->get('/pokemons/{name}', 'App\Pokemons\Controller\PokemonsController::getPokemonAction')->bind('pokemons.entity');

//OwnedPokemon
$app->get('/pokemons/owned/{user_id}', 'App\Pokemons\Controller\PokemonsController::getOwnedPokemonAction')->bind('pokemons.ownedList');
$app->post('/pokemons/owned', 'App\Pokemons\Controller\PokemonsController::insertOwnedPokemonAction')->bind('pokemons.ownedinsert');
$app->put('/pokemons/owned', 'App\Pokemons\Controller\PokemonsController::updateOwnedPokemonAction')->bind('pokemons.ownedUpdate');
$app->delete('/pokemons/owned/{pokemon_id}/{user_id}', 'App\Pokemons\Controller\PokemonsController::deleteOwnedPokemonAction')->bind('pokemons.ownedDelete');

$app->post('/pokemons/img', 'App\Pokemons\Controller\PokemonsController::insertImgAction')->bind('pokemons.insertImg');



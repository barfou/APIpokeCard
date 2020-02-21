<?php

/*$app->get('/users/list', 'App\Controller\UsersController::listAction')->bind('users.list');
$app->get('/users/edit/{id}', 'App\Controller\UsersController::editAction')->bind('users.edit');
$app->get('/users/new', 'App\Controller\UsersController::newAction')->bind('users.new');
$app->post('/users/delete/{id}', 'App\Controller\UsersController::deleteAction')->bind('users.delete');
$app->post('/users/save', 'App\Controller\UsersController::saveAction')->bind('users.save');*/

//User
$app->get('/users', 'App\Users\Controller\UsersController::getListUserAction')->bind('users.list');
$app->get('/users/{id}', 'App\Users\Controller\UsersController::getUserAction')->bind('users.entity');
$app->delete('/users/{id}', 'App\Users\Controller\UsersController::deleteUserAction')->bind('users.delete');
$app->post('/users/{login}', 'App\Users\Controller\UsersController::insertUserAction')->bind('users.insert');

$app->put('/users/update', 'App\Users\Controller\UsersController::updateUserAction')->bind('users.update');

/*$app->get('/users/delete', 'App\Users\Controller\UsersController::deleteUserAction')->bind('users.delete');
$app->get('/users/insert', 'App\Users\Controller\UsersController::insertUserAction')->bind('users.insert');
$app->get('/users/update', 'App\Users\Controller\UsersController::updateUserAction')->bind('users.update');*/

//Pokemon
$app->get('/pokemons', 'App\Pokemons\Controller\PokemonsController::getListPokemonAction')->bind('pokemons.list');
$app->get('/pokemons/detail', 'App\Pokemons\Controller\PokemonsController::getPokemonAction')->bind('pokemons.entity');
//$app->get('/pokemons/insertImg', 'App\Pokemons\Controller\PokemonsController::insertImgAction')->bind('pokemons.insrtImg');
/*$app->get('/pokemons/edit/{id}', 'App\Pokemons\Controller\PokemonsController::editAction')->bind('pokemons.edit');
$app->get('/pokemons/new', 'App\Pokemons\Controller\PokemonsController::newAction')->bind('pokemons.new');
$app->post('/pokemons/delete/{id}', 'App\Pokemons\Controller\PokemonsController::deleteAction')->bind('pokemons.delete');
$app->post('/pokemons/save', 'App\Pokemons\Controller\PokemonsController::saveAction')->bind('pokemons.save');*/



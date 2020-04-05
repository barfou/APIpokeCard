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
$app->delete('/users/{id}', 'App\Users\Controller\UsersController::deleteUserAction')->bind('users.delete');

//Pokemon
$app->get('/pokemons/page/{page}', 'App\Pokemons\Controller\PokemonsController::getListPokemonAction')->bind('pokemons.list');
$app->get('/pokemons/{name}', 'App\Pokemons\Controller\PokemonsController::getPokemonAction')->bind('pokemons.entity');
$app->post('/pokemons/img', 'App\Pokemons\Controller\PokemonsController::insertImgAction')->bind('pokemons.insertImg');



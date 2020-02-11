<?php

/*$app->get('/users/list', 'App\Controller\UsersController::listAction')->bind('users.list');
$app->get('/users/edit/{id}', 'App\Controller\UsersController::editAction')->bind('users.edit');
$app->get('/users/new', 'App\Controller\UsersController::newAction')->bind('users.new');
$app->post('/users/delete/{id}', 'App\Controller\UsersController::deleteAction')->bind('users.delete');
$app->post('/users/save', 'App\Controller\UsersController::saveAction')->bind('users.save');

$app->get('/pokemon/list', 'App\Controller\PokemonsController::listAction')->bind('pokemon.list');

$app->get('/article/list', 'App\Controller\ArticleController::listAction')->bind('article.list');*/


//User
$app->get('/users', 'App\Users\Controller\UsersController::getListUserAction')->bind('users.list');
$app->get('/users/{id}', 'App\Users\Controller\UsersController::getUserAction')->bind('users.get');

$app->get('/users/edit/{id}', 'App\Users\Controller\UsersController::editAction')->bind('users.edit');
$app->get('/users/new', 'App\Users\Controller\UsersController::newAction')->bind('users.new');
$app->post('/users/delete/{id}', 'App\Users\Controller\UsersController::deleteAction')->bind('users.delete');
$app->post('/users/save', 'App\Users\Controller\UsersController::saveAction')->bind('users.save');

//Pokemon
$app->get('/pokemons/{offset}{limit}', 'App\Pokemons\Controller\PokemonsController::getListPokemonAction')->bind('pokemons.list');
$app->get('/pokemons', 'App\Pokemons\Controller\PokemonsController::getListPokemonAction')->bind('pokemons.list');
$app->get('/pokemons/insertImg', 'App\Pokemons\Controller\PokemonsController::insertImgAction')->bind('pokemons.insrtImg');
//$app->get('/pokemons/{name}', 'App\Pokemons\Controller\PokemonsController::getPokemonAction')->bind('pokemons.entity');

$app->get('/pokemons/edit/{id}', 'App\Pokemons\Controller\PokemonsController::editAction')->bind('pokemons.edit');
$app->get('/pokemons/new', 'App\Pokemons\Controller\PokemonsController::newAction')->bind('pokemons.new');
$app->post('/pokemons/delete/{id}', 'App\Pokemons\Controller\PokemonsController::deleteAction')->bind('pokemons.delete');
$app->post('/pokemons/save', 'App\Pokemons\Controller\PokemonsController::saveAction')->bind('pokemons.save');



<?php

/*$app->get('/users/list', 'App\Controller\UsersController::listAction')->bind('users.list');
$app->get('/users/edit/{id}', 'App\Controller\UsersController::editAction')->bind('users.edit');
$app->get('/users/new', 'App\Controller\UsersController::newAction')->bind('users.new');
$app->post('/users/delete/{id}', 'App\Controller\UsersController::deleteAction')->bind('users.delete');
$app->post('/users/save', 'App\Controller\UsersController::saveAction')->bind('users.save');

$app->get('/pokemon/list', 'App\Controller\PokemonsController::listAction')->bind('pokemon.list');

$app->get('/article/list', 'App\Controller\ArticleController::listAction')->bind('article.list');*/

$app->get('/users/list', 'App\Users\Controller\UsersController::listAction')->bind('users.list');
$app->get('/users/edit/{id}', 'App\Users\Controller\UsersController::editAction')->bind('users.edit');
$app->get('/users/new', 'App\Users\Controller\UsersController::newAction')->bind('users.new');
$app->post('/users/delete/{id}', 'App\Users\Controller\UsersController::deleteAction')->bind('users.delete');
$app->post('/users/save', 'App\Users\Controller\UsersController::saveAction')->bind('users.save');

$app->get('/pokemons/list', 'App\Pokemons\Controller\UsersController::listAction')->bind('pokemons.list');
$app->get('/pokemons/edit/{id}', 'App\Pokemons\Controller\UsersController::editAction')->bind('pokemons.edit');
$app->get('/pokemons/new', 'App\Pokemons\Controller\UsersController::newAction')->bind('pokemons.new');
$app->post('/pokemons/delete/{id}', 'App\Pokemons\Controller\UsersController::deleteAction')->bind('pokemons.delete');
$app->post('/pokemons/save', 'App\Pokemons\Controller\UsersController::saveAction')->bind('pokemons.save');

$app->get('/devices/list', 'App\Devices\Controller\UsersController::listAction')->bind('devices.list');
$app->get('/devices/edit/{id}', 'App\Devices\Controller\UsersController::editAction')->bind('devices.edit');
$app->get('/devices/new', 'App\Devices\Controller\UsersController::newAction')->bind('devices.new');
$app->post('/devices/delete/{id}', 'App\Devices\Controller\UsersController::deleteAction')->bind('devices.delete');
$app->post('/devices/save', 'App\Devices\Controller\UsersController::saveAction')->bind('devices.save');



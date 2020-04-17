<?php

namespace App\Users\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController
{
    public function getListUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $users = $app['repository.user']->getAll();

        if($users !== []){
            $response->setContent(json_encode($users));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
        }
        return $response;
    }

    public function getUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $parameters = $request->attributes->all();
        $user = $app['repository.user']->getById($parameters['id']);

        if($user !== []){
            $response->setContent(json_encode($user));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
             $response->setContent(json_encode("404 ERROR"));
             $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
    }

    public function insertUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $parametersInsert = [
            "login" => $_POST['login'],
            "mail" => $_POST['mail'],
            "password" => $_POST['password']
        ];
        $bool = $app['repository.user']->insert($parametersInsert);
        if($bool == true){
            $response->setContent(json_encode("Request executed"));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setContent(json_encode("Request not executed"));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
    }

    public function updateUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        //Permet de récupéré les paramètres de la requete
        $_PUT = array();
        parse_str(file_get_contents("php://input"), $_PUT);

        $parametersUpdate = [
            "id" => $_PUT['id'],
            "login" => $_PUT['login'],
            "mail" => $_PUT['mail'],
            "password" => $_PUT['password']

        ];
        $bool = $app['repository.user']->update($parametersUpdate);
        if($bool == true){
            $response->setContent(json_encode("Request executed"));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setContent(json_encode("Request not executed"));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
    }

    public function updatePokePointsUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        //Permet de récupéré les paramètres de la requete
        $_PUT = array();
        parse_str(file_get_contents("php://input"), $_PUT);

        $parametersUpdate = [
            "user_id" => $_PUT['user_id'],
            "poke_points" => $_PUT['poke_points']

        ];
        $bool = $app['repository.user']->updatePokePoints($parametersUpdate);
        if($bool == true){
            $response->setContent(json_encode("Request executed"));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setContent(json_encode("Request not executed"));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
    }

    public function deleteUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $parameters = $request->attributes->all();

        $count = $app['repository.pokemon']->countOwnedPokemon($parameters['id']);

        if($count != 0){
            $response->setContent(json_encode("Impossible to delete user"));
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        } else {
            $bool = $app['repository.user']->delete($parameters['id']);
            if($bool == true){
                $response->setContent(json_encode("Request executed"));
                $response->setStatusCode(Response::HTTP_OK);
            }
            else{
                $response->setContent(json_encode("Request not executed"));
                $response->setStatusCode(Response::HTTP_NOT_FOUND);
            }
        }
        return $response;
    }


}

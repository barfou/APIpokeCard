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

    public function deleteUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $parameters = $request->attributes->all();
        $bool = $app['repository.user']->delete($parameters['id']);
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
}

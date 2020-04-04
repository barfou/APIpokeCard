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
        //$response = new Response();
        //$response->headers->set('Content-Type', 'application/json');

        //$parameters = $request;
        var_dump($request);
        var_dump($_POST["login"]);
        //var_dump($parameters->parameters);

        //$parametersInsert = [
        //    "login" => $parameters['login'],
        //    "mail" => $parameters['mail'],
        //    "password" => $parameters['password']
        //];
        //$bool = $app['repository.user']->insert($parametersInsert);
        //if($bool == true){
        //    $response->setContent(json_encode("Request executed"));
        //    $response->setStatusCode(Response::HTTP_OK);
        //}
        //else{
        //    $response->setContent(json_encode("Request not executed"));
        //    $response->setStatusCode(Response::HTTP_NOT_FOUND);
        //}
        //return $response;
        return "";
    }

    public function updateUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $parameters = $request->attributes->all();
        $parametersUpdate = [
            "id" => $parameters['id'],
            "login" => $parameters['login'],
            "mail" => $parameters['mail'],
            "password" => $parameters['password']

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

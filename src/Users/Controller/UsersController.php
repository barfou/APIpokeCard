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
            $responseJson = [
                "response" => "Request executed"
            ];
            $response->setContent(json_encode($responseJson));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $responseJson = [
                "response" => "Request not executed"
            ];
            $response->setContent(json_encode($responseJson));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
    }

    public function insertUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $parameters = $request->attributes->all();
        $parametersInsert = [
            "login" => $parameters['login'],
            "mail" => $parameters['mail'],
            "password" => $parameters['password']
        ];
        $bool = $app['repository.user']->insert($parametersInsert);
        if($bool == true){
            $responseJson = [
                "response" => "Request executed"
            ];
            $response->setContent(json_encode($responseJson));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $responseJson = [
                "response" => "Request not executed"
            ];
            $response->setContent(json_encode($responseJson));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
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
            $responseJson = [
                "response" => "Request executed"
            ];
            $response->setContent(json_encode($responseJson));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $responseJson = [
                "response" => "Request not executed"
            ];
            $response->setContent(json_encode($responseJson));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
    }



    /*public function editAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $user = $app['repository.user']->getById($parameters['id']);

        return $app['twig']->render('users.form.html.twig', array('user' => $user));
    }

    public function saveAction(Request $request, Application $app)
    {
        $parameters = $request->request->all();
        if (isset($parameters['id'])) {
            $user = $app['repository.user']->update($parameters);
        } else {
            $user = $app['repository.user']->insert($parameters);
        }

        return $app->redirect($app['url_generator']->generate('users.list'));
    }

    public function newAction(Request $request, Application $app)
    {
        return $app['twig']->render('users.form.html.twig');
    }*/
}

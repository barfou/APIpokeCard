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

        $response->setContent(json_encode($users));
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }

    public function getUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        //$parameters = $request->attributes->all();
        $id = $_GET["id"];
        $user = $app['repository.user']->getById($id);

        $response->setContent(json_encode($user));
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }

    public function deleteUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $id = $_GET["id"];
        $bool = $app['repository.user']->delete($id);
        if($bool = true){
            $response->setContent(json_encode("Request executed"));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setContent(json_encode("Request not executed"));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
        //$method = $request->getRealMethod();
        //$msg = "about: " . $method;
        //return $msg;
    }

    public function insertUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        //$parameters = $request->request->all();
        $parameters = [
            "login" => $_GET["login"],
            "mail" => $_GET["mail"],
            "password" => $_GET["password"]
        ];
        $bool = $app['repository.user']->insert($parameters);
        if($bool = true){
            $response->setContent(json_encode("Request executed"));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setContent(json_encode("Request not executed"));
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $bool;
    }

    public function updateUserAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        //$parameters = $request->request->all();
        $parameters = [
            "id" => $_GET["id"],
            "login" => $_GET["login"],
            "mail" => $_GET["mail"],
            "password" => $_GET["password"]
        ];
        $bool = $app['repository.user']->update($parameters);
        if($bool = true){
            $response->setContent(json_encode("Request executed"));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setContent(json_encode("Request not executed"));
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

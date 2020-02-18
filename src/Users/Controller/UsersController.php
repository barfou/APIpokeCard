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
        $id = $_GET["id"];
        $app['repository.user']->delete($id);
        return "OK";
        //$method = $request->getRealMethod();
        //$msg = "about: " . $method;
        //return $msg;
    }

    public function insertAction(Request $request, Application $app)
    {
        //$parameters = $request->request->all();
        $parameters = [
            "login" => $_GET["login"],
            "mail" => $_GET["mail"],
            "password" => $_GET["password"]
        ];
        $user = $app['repository.user']->insert($parameters);
        return "OK";
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

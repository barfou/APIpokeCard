<?php

namespace App\Users\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController
{
    public function getListUserAction(Request $request, Application $app)
    {
        $users = $app['repository.user']->getAll();
        $usersEncodeJson = json_encode($users);
        return $usersEncodeJson;
    }

    public function getUserAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $user = $app['repository.user']->getById($parameters['id']);
        $userEncodeJson = json_encode($user);
        return $userEncodeJson;
    }

    public function deleteAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $app['repository.user']->delete($parameters['id']);

        return $app->redirect($app['url_generator']->generate('users.list'));
    }

    public function editAction(Request $request, Application $app)
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
    }
}

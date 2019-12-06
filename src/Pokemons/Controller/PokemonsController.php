<?php

namespace App\Pokemons\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
//use App\Pokemon\Repository\PokemonRepository;

class PokemonsController
{
    public function getListPokemonAction(Request $request, Application $app)
    {
        $url = "https://pokeapi.co/api/v2/pokemon?offset=0&limit=151";

        //Create Response object
        $response = new Response();

        // Function to get HTTP response code  
        function get_http_response_code($url) { 
            $headers = get_headers($url); 
            return substr($headers[0], 9, 3); 
        } 
             
        // Check HTTP response code is 200 or not 
        if (get_http_response_code($url) == 200 ){
            $response->setContent(file_get_contents($url));
            $response->headers->set('Content-Type', 'application/json');
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setContent("HTTP request not successfully!");
            $response->headers->set('Content-Type', 'text/html');
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }  
        return $response;
    }

    public function getPokemonAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $httpsfile = file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $parameters['name']);
        $jsonDecoded = json_decode($httpsfile);
        //var_dump($jsonDecoded);
        $baseInfos = $jsonDecoded->name . ' ' . $jsonDecoded->height . ' ' . $jsonDecoded->weight; // . ' ' . $jsonDecoded->sprites . ' ' .  $jsonDecoded->abilities;
        $abilitiesStdClass = $jsonDecoded->abilities;
        $abilities = "";
        /*for($i = 0; $i > $abilitiesStdClass.size; $i++ ){
            $abilities += $abilitiesStdClass[$i]->ability->name;
        }
        $abilities = $jsonDecoded->abilities[0]->ability->name;
        foreach ($jsonDecoded->abilities as &$value) {
            $abilities += $value->ability->name;
        }*/
        return $baseInfos . "\r" . $abilities;
    }

    public function deleteAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $app['repository.device']->delete($parameters['id']);

        return $app->redirect($app['url_generator']->generate('device.list'));
    }

    public function editAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $device = $app['repository.device']->getById($parameters['id']);

        return $app['twig']->render('device.form.html.twig', array('device' => $device));
    }

    public function saveAction(Request $request, Application $app)
    {
        $parameters = $request->request->all();
        if (isset($parameters['id'])) {
            $device = $app['repository.device']->update($parameters);
        } else {
            $device = $app['repository.device']->insert($parameters);
        }

        return $app->redirect($app['url_generator']->generate('device.list'));
    }

    public function newAction(Request $request, Application $app)
    {
        $users = $app['repository.user']->getAll();

        return $app['twig']->render('device.form.html.twig', array('users' => $users));
    }
}

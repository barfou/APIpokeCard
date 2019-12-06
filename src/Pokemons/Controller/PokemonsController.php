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
        //$httpsfile = file_get_contents("https://pokeapi.co/api/v2/pokemon?offset=0&limit=151");
        //return $httpsfile;
        $request = 

        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        //$content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        return $contentType. "\n" .$content;
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

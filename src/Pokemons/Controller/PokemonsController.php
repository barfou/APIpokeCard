<?php

namespace App\Pokemons\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use App\Pokemon\Repository\PokemonRepository;

class PokemonsController
{
    public function getListPokemonAction(Request $request, Application $app)
    {
        $url = "https://pokeapi.co/api/v2/pokemon";

        //Create Response object
        $response = new Response();

        // Function to get HTTP response code  
        function get_http_response_code($url) { 
            $headers = get_headers($url); 
            return substr($headers[0], 9, 3); 
        } 
             
        // Check HTTP response code is 200 or not 
        if (get_http_response_code($url) == 200 ){
            $response->headers->set('Content-Type', 'application/json');

            //if count base different count api
            //
            //

            $httpsfile = file_get_contents($url);
            $jsonDecoded = json_decode($httpsfile);

            $count = $jsonDecoded->count;
            $next = $jsonDecoded->next;
            $previous = $jsonDecoded->previous;

            $resultsStdClass = $jsonDecoded->results;
            $results = [];
            for($i = 0; $i < count((array)$resultsStdClass); $i++){
                $name = $resultsStdClass[$i]->name;
                $url = $resultsStdClass[$i]->url;

                $sprites = $app['repository.pokemon']->getImgByName($name);

                $urlImagBack = "";// = $pokemon->getUrlImgBack;
                $urlImagFront = "";// = $pokemon->getUrlImgFront;

                $result = [
                    "name" => $name,
                    "url" => $url,
                    "urlImgBack" => $urlImagBack,
                    "urlImgFront" => $urlImagFront
                ];
                array_push($results, $result);
            }

            $pokemonInfos = [
                "count" => $count,
                "next" => $next,
                "previous" => $previous,
                "results" => $results
            ];

            $response->setContent(json_encode($pokemonInfos));
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
        $url = "https://pokeapi.co/api/v2/pokemon/" . $parameters['name'];

        //Create Response object
        $response = new Response();

        // Function to get HTTP response code  
        function get_http_response_code($url) { 
            $headers = get_headers($url); 
            return substr($headers[0], 9, 3); 
        } 

        // Check HTTP response code is 200 or not 
        if (get_http_response_code($url) == 200 ){
            $response->headers->set('Content-Type', 'application/json');

            $httpsfile = file_get_contents($url);
            $jsonDecoded = json_decode($httpsfile);

            $name = $jsonDecoded->name;
            $height = $jsonDecoded->height;
            $weight = $jsonDecoded->weight;
            $id = $jsonDecoded->id;

            $abilitiesStdClass = $jsonDecoded->abilities;
            $abilities = [];
            for($i = 0; $i < count((array)$abilitiesStdClass); $i++){
                $abilitie = [
                    "name" => $abilitiesStdClass[$i]->ability->name,
                    "url" => $abilitiesStdClass[$i]->ability->url
                ];
                array_push($abilities, $abilitie );
            }

            $sprites = [
                "back_default" => $jsonDecoded->sprites->back_default,
                "front_default" => $jsonDecoded->sprites->front_default
            ];

            $statsStdClass = $jsonDecoded->stats;
            $stats = [];
            for($i = 0; $i < count((array)$statsStdClass); $i++){
                $base_stat = $statsStdClass[$i]->base_stat;
                $effort = $statsStdClass[$i]->effort;
                $statStdClass = $statsStdClass[$i]->stat;
                $statName = $statStdClass->name;
                $statUrl = $statStdClass->url;

                $stat = [
                    "base_stat" => $base_stat,
                    "effort" => $effort, 
                    "stat" => [
                        "name" => $statName,
                        "url" => $statUrl
                    ]
                ];
                array_push($stats, $stat);
            }
            
            $pokemonInfos = [
                "abilities" => $abilities,
                "height" => $height,
                "id" => $id,
                "sprites" => $sprites,
                "stats" => $stats,
                "weight" => $weight
            ];

            $response->setContent(json_encode($pokemonInfos));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setContent("HTTP request not successfully!");
            $response->headers->set('Content-Type', 'text/html');
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }  
        return $response;
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

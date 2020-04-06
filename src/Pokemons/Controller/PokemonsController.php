<?php

namespace App\Pokemons\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PokemonsController
{
    public function getListPokemonAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $offset = $parameters['page'] * 20;
        $url = "https://pokeapi.co/api/v2/pokemon?offset=" . $offset . "&limit=" . "&limit=20";

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

                $urlBackImg = $sprites["urlBackImg"];
                $urlFrontImg = $sprites["urlFrontImg"];

                $result = [
                    "name" => $name,
                    "url" => $url,
                    "urlBackImg" => $urlBackImg,
                    "urlFrontImg" => $urlFrontImg
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
            $response->setContent(json_encode("HTTP request not successfully!"));
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
                    "ability" => [
                        "name" => $abilitiesStdClass[$i]->ability->name,
                        "url" => $abilitiesStdClass[$i]->ability->url
                    ]
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
                $statStdClass = $statsStdClass[$i]->stat;
                $statName = $statStdClass->name;
                $statUrl = $statStdClass->url;

                $stat = [
                    "base_stat" => $base_stat,
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
                "name" => $name,
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

    public function getOwnedPokemonAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $parameters = $request->attributes->all();
        $ownedPokemons = $app['repository.pokemon']->getOwnedPokemon($parameters['user_id']);

        if($ownedPokemons !== []){
            // Function to get HTTP response code
            function get_http_response_code($url) {
                $headers = get_headers($url);
                return substr($headers[0], 9, 3);
            }

            $tblOwnedPokemons = [];

            foreach ($ownedPokemons as &$id) {
                $url = "https://pokeapi.co/api/v2/pokemon/" . $id;

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
                            "ability" => [
                                "name" => $abilitiesStdClass[$i]->ability->name,
                                "url" => $abilitiesStdClass[$i]->ability->url
                            ]
                        ];
                        array_push($abilities, $abilitie);
                    }

                    $sprites = [
                        "back_default" => $jsonDecoded->sprites->back_default,
                        "front_default" => $jsonDecoded->sprites->front_default
                    ];

                    $statsStdClass = $jsonDecoded->stats;
                    $stats = [];
                    for($i = 0; $i < count((array)$statsStdClass); $i++){
                        $base_stat = $statsStdClass[$i]->base_stat;
                        $statStdClass = $statsStdClass[$i]->stat;
                        $statName = $statStdClass->name;
                        $statUrl = $statStdClass->url;

                        $stat = [
                            "base_stat" => $base_stat,
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
                        "name" => $name,
                        "sprites" => $sprites,
                        "stats" => $stats,
                        "weight" => $weight
                    ];

                    array_push($tblOwnedPokemons, $pokemonInfos);
                }
            }
            $response->setContent(json_encode($tblOwnedPokemons));
            $response->setStatusCode(Response::HTTP_OK);
        }
        else{
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        }
        return $response;
    }

    public function insertOwnedPokemonAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        $parametersInsert = [
            "pokemon_id" => $_POST['pokemon_id'],
            "user_id" => $_POST['user_id']
        ];
        $bool = $app['repository.pokemon']->insertOwnedPokemon($parametersInsert);
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

    public function updateOwnedPokemonAction(Request $request, Application $app)
    {
        //Create Response object
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');

        //Permet de récupéré les paramètres de la requete
        $_PUT = array();
        parse_str(file_get_contents("php://input"), $_PUT);

        $parametersUpdate = [
            "pokemon_id" => $_PUT['pokemon_id'],
            "user_id" => $_PUT['user_id'],
            "new_user_id" => $_PUT['new_user_id']

        ];
        $bool = $app['repository.pokemon']->updateOwnedPokemon($parametersUpdate);
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

    public function deleteOwnedPokemonAction(Request $request, Application $app)
        {
            //Create Response object
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');

            $parameters = $request->attributes->all();

            $parametersDelete = [
                "pokemon_id" => $parameters['pokemon_id'],
                "user_id" => $parameters['user_id']
            ];
            $bool = $app['repository.pokemon']->deleteOwnedPokemon($parametersDelete);
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

    public function insertImgAction(Request $request, Application $app)
    {
        $bool = true;
        $url = "https://pokeapi.co/api/v2/pokemon?offset=0&limit=964";
        $httpsfile = file_get_contents($url);
        $jsonDecoded = json_decode($httpsfile);

        $resultsStdClass = $jsonDecoded->results;
        $results = [];
        for($i = 0; $i < count((array)$resultsStdClass); $i++){
            if($bool == true){
                $name = $resultsStdClass[$i]->name;

                $urldetail = "https://pokeapi.co/api/v2/pokemon/" . $name;

                $httpsfile = file_get_contents($urldetail);
                $jsonDecoded = json_decode($httpsfile);

                $sprites = [
                    "back_default" => $jsonDecoded->sprites->back_default,
                    "front_default" => $jsonDecoded->sprites->front_default
                ];

                $urlBackImg = $sprites["back_default"];
                $urlFrontImg = $sprites["front_default"];

                $parameters = [
                    'name' => $name,
                    'urlImgBack' => $urlBackImg,
                    'urlImgFront' => $urlFrontImg
                ];
                $bool = $app['repository.pokemon']->insertImg($parameters);
            }
        }
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

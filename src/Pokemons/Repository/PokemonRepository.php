<?php

namespace App\Pokemons\Repository;

use App\Entity\Pokemon;
use Doctrine\DBAL\Connection;
/**
 * pokemon repository.
 */
class PokemonRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getImgByName($name)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('pr.*')
            ->from('PokemonRef', 'pr')
            ->where('name = ?')
            ->setParameter(0, $name);
        $statement = $queryBuilder->execute();
        $pokemonData = $statement->fetchAll();
        if($pokemonData){
            $sprites = [
                "urlBackImg" => $pokemonData[0]['urlImgBack'],
                "urlFrontImg" => $pokemonData[0]['urlImgFront']
            ];
            //$sprites = $pokemonData[0]['urlImgFront'];
          }
          else {
            $sprites = [
                "urlBackImg" => "",
                "urlFrontImg" => ""
            ];
            //$sprites = "";
          }
          return $sprites;
    }

    public function insertOwnedPokemon($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->insert('OwnedPokemon')
            ->values(
                array(
                    'pokemon_id' => ':pokemon_id',
                    'user_id' => ':user_id'
                )
            )
            ->setParameter(':pokemon_id', $parameters['pokemon_id'])
            ->setParameter(':user_id', $parameters['user_id']);
        $statement = $queryBuilder->execute();
        return $statement;
    }

    public function updateOwnedPokemon($parameters)
        {
            $queryBuilder = $this->db->createQueryBuilder();
            $queryBuilder
                ->update('OwnedPokemon')
                ->set('user_id', ':user_id')
                ->where('pokemon_id = :pokemon_id AND user_id = :user_id')
                ->setParameter(':pokemon_id', $parameters['pokemon_id'])
                ->setParameter(':user_id', $parameters['user_id']);

            $statement = $queryBuilder->execute();
            return $statement;
        }

    public function insertImg($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->insert('PokemonRef')
            ->values(
                array(
                    'name' => ':name',
                    'urlImgBack' => ':urlImgBack',
                    'urlImgFront' => ':urlImgFront'
                )
            )
            ->setParameter(':name', $parameters['name'])
            ->setParameter(':urlImgBack', $parameters['urlImgBack'])
            ->setParameter(':urlImgFront', $parameters['urlImgFront']);
        $statement = $queryBuilder->execute();
        return $statement;
    }
}

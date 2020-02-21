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

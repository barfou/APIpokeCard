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

    protected $pokemonRepository;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**public function getCount()
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder->select('count(pr.*)')
            ->from('PokemonRef', 'pr');
            $count = $queryBuilder->execute()->fetchAll();

        return $count;


    }**/

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

    public function insert($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->insert('CreatedPokemon')
            ->values(
                array(
                'name' => ':name',
                'height' => ':height',
                'weight' => ':weight'
                )
            )
            ->setParameter(':name', $parameters['name'])
            ->setParameter(':height', $parameters['height'])
            ->setParameter(':weight', $parameters['weight']);
        $statement = $queryBuilder->execute();
        return $statement;
    }

    /*public function insertImg($parameters)
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
    }*/

    /**
     * Returns a collection of pokemons.
     *
     * @param int $limit
     *   The number of pokemons to return.
     * @param int $offset
     *   The number of pokemons to skip.
     * @param array $orderBy
     *   Optionally, the order by info, in the $column => $direction format.
     *
     * @return array A collection of pokemons, keyed by pokemon id.
     */

    public function getAll()
    {
        /*$queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('d.*')
            ->from('pokemons', 'd');
        $statement = $queryBuilder->execute();
        $pokemonData = $statement->fetchAll();
        foreach ($pokemonData as $pokemonData) {
            $pokemonEntityList[$pokemonData['id']] = new pokemon($pokemonData['id'], $pokemonData['lib'], $pokemonData['marque'], $pokemonData['os'], $this->userRepository->getById($pokemonData['userid']));
        }
        return $pokemonEntityList;*/
        /**
         * Returns an pokemons object.
         *
         * @param $id
         *   The id of the pokemon to return.
         *
         * @return array A collection of pokemons, keyed by pokemon id.
         */
    }

    public function getById($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('d.*')
            ->from('pokemons', 'd')
            ->where('id = ?')
            ->setParameter(0, $id);
        $statement = $queryBuilder->execute();
        $pokemonData = $statement->fetchAll();

        return new pokemon($pokemonData[0]['id'], $pokemonData[0]['lib'], $pokemonData[0]['marque'], $pokemonData[0]['os'], $this->userRepository->getById($pokemonData['userid']));
    }

    public function delete($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->delete('pokemons')
            ->where('id = :id')
            ->setParameter(':id', $id);

        $statement = $queryBuilder->execute();
    }

    public function update($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->update('pokemons')
            ->where('id = :id')
            ->setParameter(':id', $parameters['id']);

        if ($parameters['lib']) {
            $queryBuilder
                ->set('lib', ':lib')
                ->setParameter(':lib', $parameters['lib']);
        }

        if ($parameters['marque']) {
            $queryBuilder
                ->set('marque', ':marque')
                ->setParameter(':marque', $parameters['marque']);
        }

        if ($parameters['os']) {
            $queryBuilder
                ->set('os', ':os')
                ->setParameter(':os', $parameters['os']);
        }

        if ($parameters['userid']) {
            $queryBuilder
                ->set('userid', ':userid')
                ->setParameter(':userid', $parameters['userid']);
        }

        $statement = $queryBuilder->execute();
    }
}

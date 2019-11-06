<?php

namespace App\Pokemon\Repository;

use App\Pokemon\Entity\Pokemon;
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

    protected $userRepository;

    public function __construct(Connection $db, UserRepository $userRepository)
    {
        $this->db = $db;
        $this->userRepository = $userRepository;
    }

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

    public function insert($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->insert('pokemons')
            ->values(
                array(
                    'lib' => ':lib',
                    'marque' => ':marque',
                    'os' => ':os',
                    'userid' => ':userid'
                )
            )
            ->setParameter(':lib', $parameters['lib'])
            ->setParameter(':marque', $parameters['marque'])
            ->setParameter(':os', $parameters['os'])
            ->setParameter(':userid', $parameters['cboUser']);
        $statement = $queryBuilder->execute();
    }
}

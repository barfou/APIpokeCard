<?php
namespace App\Users\Repository;
use App\Users\Entity\User;
use Doctrine\DBAL\Connection;
/**
 * User repository.
 */
class UserRepository
{
    /**
    * @var \Doctrine\DBAL\Connection
    */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    /**
    * Returns a collection of users.
    *
    * @param int $limit
    *   The number of users to return.
    * @param int $offset
    *   The number of users to skip.
    * @param array $orderBy
    *   Optionally, the order by info, in the $column => $direction format.
    *
    * @return array A collection of users, keyed by user id.
    */
    public function getAll()
    {
        $userEntityList = [];
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('User', 'u');
        $statement = $queryBuilder->execute();
        $usersData = $statement->fetchAll();
        foreach ($usersData as $userData) {
            //$userEntityList[$userData['id']] = new User($userData['id'], $userData['login'], $userData['mail'], $userData['password']);
            $user = [
                "id" => $userData['id'],
                "login" => $userData['login'],
                "mail" => $userData['mail'],
                "password" => $userData['password']
            ];
            array_push($userEntityList, $user);
        }
        return $userEntityList;
    }
    /**
    * Returns an User object.
    *
    * @param $id
    *   The id of the user to return.
    *
    * @return array A collection of users, keyed by user id.
    */
    public function getById($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('User', 'u')
            ->where('id = ?')
            ->setParameter(0, $id);
        $statement = $queryBuilder->execute();
        $userData = $statement->fetchAll();
        if($userData){
            $user = [
                "id" => $userData[0]['id'],
                "login" => $userData[0]['login'],
                "mail" => $userData[0]['mail'],
                "password" => $userData[0]['password']
            ];
        }
        else {
            $user = [];
        }
        return $user;
    }

    public function insert($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->insert('User')
            ->values(
                array(
                'login' => ':login',
                'mail' => ':mail',
                'password' => ':password'
                )
            )
            ->setParameter(':login', $parameters['login'])
            ->setParameter(':mail', $parameters['mail'])
            ->setParameter(':password', $parameters['password']);
        $statement = $queryBuilder->execute();
        return $statement;
    }

    public function update($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->update('User')
            ->where('id = :id')
            ->setParameter(':id', $parameters['id']);

        if ($parameters['login']) {
            $queryBuilder
                ->set('login', ':login')
                ->setParameter(':login', $parameters['login']);
        }
        if ($parameters['mail']) {
            $queryBuilder
                ->set('mail', ':mail')
                ->setParameter(':mail', $parameters['mail']);
        }
        if ($parameters['password']) {
            $queryBuilder
                ->set('password', ':password')
                ->setParameter(':password', $parameters['password']);
        }

        $statement = $queryBuilder->execute();
        return $statement;
    }

    public function updatePokePoints($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->update('User')
            ->where('id = :user_id')
            ->setParameter(':user_id', $parameters['user_id']);

        if ($parameters['poke_points']) {
            $queryBuilder
                ->set('poke_points', ':poke_points')
                ->setParameter(':poke_points', $parameters['poke_points']);
        }

        $statement = $queryBuilder->execute();
        return $statement;
    }

    public function delete($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->delete('User')
            ->where('id = :id')
            ->setParameter(':id', $id);
        $statement = $queryBuilder->execute();
        return $statement;
    }
}

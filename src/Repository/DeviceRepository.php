<?php

namespace App\Devices\Repository;

use App\Devices\Entity\Device;
use Doctrine\DBAL\Connection;
use App\Users\Repository\UserRepository;

/**
 * Device repository.
 */
class DeviceRepository
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
    * Returns a collection of devices.
    *
    * @param int $limit
    *   The number of devices to return.
    * @param int $offset
    *   The number of devices to skip.
    * @param array $orderBy
    *   Optionally, the order by info, in the $column => $direction format.
    *
    * @return array A collection of devices, keyed by device id.
    */
   public function getAll()
   {
       $queryBuilder = $this->db->createQueryBuilder();
       $queryBuilder
           ->select('d.*')
           ->from('devices', 'd');

       $statement = $queryBuilder->execute();
       $deviceData = $statement->fetchAll();
       foreach ($deviceData as $deviceData) {
           $deviceEntityList[$deviceData['id']] = new Device($deviceData['id'], $deviceData['lib'], $deviceData['marque'], $deviceData['os'], $this->userRepository->getById($deviceData['userid']));
       }

       return $deviceEntityList;
   }

   /**
    * Returns an Devices object.
    *
    * @param $id
    *   The id of the device to return.
    *
    * @return array A collection of devices, keyed by device id.
    */
   public function getById($id)
   {
       $queryBuilder = $this->db->createQueryBuilder();
       $queryBuilder
           ->select('d.*')
           ->from('devices', 'd')
           ->where('id = ?')
           ->setParameter(0, $id);
       $statement = $queryBuilder->execute();
       $deviceData = $statement->fetchAll();

       return new Device($deviceData[0]['id'], $deviceData[0]['lib'], $deviceData[0]['marque'], $deviceData[0]['os'], $this->userRepository->getById($deviceData['userid']));
   }

    public function delete($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
          ->delete('devices')
          ->where('id = :id')
          ->setParameter(':id', $id);

        $statement = $queryBuilder->execute();
    }

    public function update($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
          ->update('devices')
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
          ->insert('devices')
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

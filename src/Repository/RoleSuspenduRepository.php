<?php

namespace App\Repository;

use App\Entity\RoleSuspendu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoleSuspendu>
 */
class RoleSuspenduRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoleSuspendu::class);
    }

    public function  getRolesSuspendues(){
        
        $sql = '
        select r.* from role_suspendu r where NOW() BETWEEN r.date_suspension AND r.date_fin_suspension OR r.date_fin_suspension IS NULL;;
        ';

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        return $resultSet->fetchAllAssociative();
    }
}

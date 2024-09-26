<?php

namespace App\Repository;

use App\Entity\PrixCharge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrixCharge>
 */
class PrixChargeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrixCharge::class);
    }
    public function getLastPrix_by_Date_by_idCharge(\DateTime $date , int $id_Charge)
    {
        $sql = 'SELECT * FROM Prix_Charge WHERE id = (
                SELECT MAX(id) 
                FROM Prix_Charge 
                WHERE date_insertion_prix_charge <= :date_modif
                AND id_charge_id = :id_Charge
            )';
    
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('date_modif', $date->format('Y-m-d'));
        $stmt->bindValue('id_Charge', $id_Charge);
        
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAssociative();
    }

    //    /**
    //     * @return PrixCharge[] Returns an array of PrixCharge objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PrixCharge
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

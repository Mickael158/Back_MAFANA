<?php

namespace App\Repository;

use App\Entity\QuiSommeNous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuiSommeNous>
 */
class QuiSommeNousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuiSommeNous::class);
    }

    public function getLast(){
            $sql = "select id from qui_somme_nous where id = (SELECT MAX(id) FROM qui_somme_nous) AND date_fin_mondat >= NOW()";
            $conn = $this->getEntityManager()->getConnection();
            $stmt = $conn->prepare($sql);
            $resultSet = $stmt->executeQuery();

            return $resultSet->fetchAllAssociative();
    }


    //    /**
    //     * @return QuiSommeNous[] Returns an array of QuiSommeNous objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?QuiSommeNous
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

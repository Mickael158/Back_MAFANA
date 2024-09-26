<?php

namespace App\Repository;

use App\Entity\Tresoreri;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tresoreri>
 */
class TresoreriRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tresoreri::class);
    }
    public function LastTresoreri()
    {
        $sql = 'select * from tresoreri where id=(select MAX(id) from tresoreri)';

        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAssociative();
    }
    public function getStatTresoreri()
    {
    $sql = 'SELECT t1.id, t1.montant, t1.date_tresoreri
            FROM tresoreri t1
            JOIN (
                SELECT MAX(date_tresoreri) AS latest_date
                FROM tresoreri
                WHERE date_tresoreri >= NOW() - INTERVAL \'7 months\'
                GROUP BY EXTRACT(YEAR FROM date_tresoreri), EXTRACT(MONTH FROM date_tresoreri)
            ) t2
            ON t1.date_tresoreri = t2.latest_date
            ORDER BY t1.date_tresoreri DESC';
    
    $conn = $this->getEntityManager()->getConnection();
    
    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery();
    
    return $resultSet->fetchAllAssociative();
    }


    //    /**
    //     * @return Tresoreri[] Returns an array of Tresoreri objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tresoreri
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

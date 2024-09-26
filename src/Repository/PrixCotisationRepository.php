<?php

namespace App\Repository;

use App\Entity\PrixCotisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrixCotisation>
 */
class PrixCotisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrixCotisation::class);
    }
    // public function getLastPrix(){
    //     return $this->createQueryBuilder('PrixCotisation')
    //     ->select('PrixCotisation')
    //     ->orderBy('Desc','PrixCotisation.id')
    //     ->setMaxResults(1)
    //     ->getQuery()
    //     ->getResult();
    // }
    public function getLastPrix_by_Date(\DateTime $date)
{
    $sql = 'SELECT * FROM Prix_Cotisation WHERE id = (
                SELECT MAX(id) 
                FROM Prix_Cotisation 
                WHERE date_modif <= :date_modif
            )';

    $conn = $this->getEntityManager()->getConnection();
    
    $stmt = $conn->prepare($sql);
    $stmt->bindValue('date_modif', $date->format('Y-m-d'));
    
    $resultSet = $stmt->executeQuery();
    
    return $resultSet->fetchAssociative();
}



    //    /**
    //     * @return PrixCotisation[] Returns an array of PrixCotisation objects
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

    //    public function findOneBySomeField($value): ?PrixCotisation
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

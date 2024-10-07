<?php

namespace App\Repository;

use App\Entity\Profession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Profession>
 */
class ProfessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profession::class);
    }
    public function getProfession_By_personne(int $id_personne)
    {
        $sql = 'SELECT p.*
                    FROM profession p
                    LEFT JOIN personne_membre_profession pmp ON pmp.id_profession_id = p.id AND pmp.id_personne_membre_id = '.$id_personne.'
                    WHERE pmp.id_personne_membre_id IS NULL;'; 
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return Profession[] Returns an array of Profession objects
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

    //    public function findOneBySomeField($value): ?Profession
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

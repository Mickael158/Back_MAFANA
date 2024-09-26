<?php

namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Materiel>
 */
class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materiel::class);
    }
    public function getMaterielExistant()
    {
        $sql = 'WITH donnation_counts AS (
    SELECT id_materiel_id, SUM(nombre) AS nombre
    FROM donnation_materiel
    GROUP BY id_materiel_id
),
validation_counts AS (
    SELECT dm.id_materiel_id, SUM(vdm.nombre) AS nombre_valide
    FROM validation_demande_materiel vdm
    JOIN demande_materiel dm ON dm.id = vdm.id_demande_materiel_id
    GROUP BY dm.id_materiel_id
),
allMaterielExistant AS (
    SELECT DISTINCT id_materiel_id FROM donnation_materiel
),
materiel_diff AS (
    SELECT 
        dc.id_materiel_id, 
        COALESCE(dc.nombre, 0) - COALESCE(vc.nombre_valide, 0) AS difference
    FROM donnation_counts dc
    LEFT JOIN validation_counts vc ON dc.id_materiel_id = vc.id_materiel_id
)
SELECT m.*
FROM materiel m
JOIN allMaterielExistant am ON am.id_materiel_id = m.id
JOIN materiel_diff md ON md.id_materiel_id = m.id
WHERE md.difference != 0';
        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return Materiel[] Returns an array of Materiel objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Materiel
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

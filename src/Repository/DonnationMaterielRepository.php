<?php

namespace App\Repository;

use App\Entity\DonnationMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DonnationMateriel>
 */
class DonnationMaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonnationMateriel::class);
    }


    public function rechercheMateriel($data, $materiel,$dataeDebut, $dataeFin)
    {
        $sql = "SELECT dm.*,m.* FROM donnation_materiel dm
        JOIN materiel m ON dm.id_materiel_id = m.id  WHERE 1=1"; 

        if ($data !== null) {
            $sql .= " AND dm.nom_donnateur_materiel = '" . $data . "'";
        }
        if ($materiel !== null) {
            $sql .= " AND dm.id_materiel_id = ".$materiel;
        }
        if ($dataeDebut !== null && $dataeFin !== null) {
            $sql .= " AND dm.date_acquisition BETWEEN '" . $dataeDebut . "' AND '" . $dataeFin . "'";
        }
        if ($data == null && $dataeDebut == null && $dataeFin == null) {
            $sql .= " LIMIT 10";
        }

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->query($sql);

        return $stmt->fetchAllAssociative();
    }
    //    /**
    //     * @return DonnationMateriel[] Returns an array of DonnationMateriel objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DonnationMateriel
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

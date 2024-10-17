<?php

namespace App\Repository;

use App\Entity\DonationFinancier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DonationFinancier>
 */
class DonationFinancierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonationFinancier::class);
    }
    public function getStatDonnation()
    {
        $sql = "SELECT 
                    DATE_TRUNC('month', date_donation_financier) AS mois,
                    SUM(montant) AS total_montant
                FROM 
                    donation_financier
                WHERE 
                    date_donation_financier >= DATE_TRUNC('month', CURRENT_DATE) - INTERVAL '6 months'
                GROUP BY 
                    DATE_TRUNC('month', date_donation_financier)
                ORDER BY 
                    mois;
            ";
        
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    public function rechercheDonation($data, $dataeDebut, $dataeFin)
    {
        $sql = "SELECT * FROM donation_financier WHERE 1=1"; 

        if ($data !== null) {
            $sql .= " AND nom_donation_financier = '" . $data . "'";
        }
        if ($dataeDebut !== null && $dataeFin !== null) {
            $sql .= " AND date_donation_financier BETWEEN '" . $dataeDebut . "' AND '" . $dataeFin . "'";
        }
        if ($data == null && $dataeDebut == null && $dataeFin == null) {
            $sql .= " LIMIT 10";
        }

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->query($sql);

        return $stmt->fetchAllAssociative();
    }
    //    /**
    //     * @return DonationFinancier[] Returns an array of DonationFinancier objects
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

    //    public function findOneBySomeField($value): ?DonationFinancier
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

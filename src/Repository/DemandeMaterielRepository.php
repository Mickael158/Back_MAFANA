<?php

namespace App\Repository;

use App\Entity\DemandeMateriel;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeMateriel>
 */
class DemandeMaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry , private readonly PersonneMembreRepository $personneMembreRepository)
    {
        parent::__construct($registry, DemandeMateriel::class);
    }

    public function getStockMateriel(int $id_materiel)
    {
        $sql = 'WITH donnation_counts AS (
        SELECT id_materiel_id, SUM(nombre) AS nombre
            FROM donnation_Materiel
        GROUP BY id_materiel_id
            ),
            validation_counts AS (
                SELECT dm.id_materiel_id, SUM(vdm.nombre) AS nombre_valide
                    FROM validation_demande_materiel vdm
                        JOIN demande_materiel dm ON dm.id = vdm.id_demande_materiel_id
                    GROUP BY dm.id_materiel_id
            )
            SELECT 
                dc.id_materiel_id, 
                COALESCE(dc.nombre, 0) - COALESCE(vc.nombre_valide, 0) AS difference
                    FROM donnation_counts dc
                LEFT JOIN validation_counts vc ON dc.id_materiel_id = vc.id_materiel_id
                WHERE dc.id_materiel_id = :id_materiel;';
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('id_materiel', $id_materiel);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    public function rechercheDemandeMateriel($data, $materielId, $dateDebut, $dateFin)
    {
        $sql = "SELECT dm.*, vdm.*, pm.* , m.*
                FROM demande_materiel dm
                JOIN validation_demande_materiel vdm ON dm.id = vdm.id_demande_materiel_id
                JOIN materiel m ON m.id=id_materiel_id
                JOIN personne_membre pm ON pm.id = dm.id_personne_membre_id 
                WHERE 1=1";

        if ($data !== null) {
            $sql .= " AND (pm.nom_membre = '".$data."' OR pm.prenom_membre = '".$data."')";
        }
        if ($materielId !== null) {
            $sql .= " AND dm.id_materiel_id = ".$materielId;
        }
        if ($dateDebut !== null && $dateFin !== null) {
            $sql .= " AND dm.date_de_demande BETWEEN '".$dateDebut."' AND '".$dateFin."'";
        }
        if ($data == null && $materielId == null && $dateDebut == null && $dateFin == null) {
            $sql .= " LIMIT 10";
        }

        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return DemandeMateriel[] Returns an array of DemandeMateriel objects
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

    //    public function findOneBySomeField($value): ?DemandeMateriel
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function differenceEnMois($dateDebut, DateTime $dateFin) {
        $dateDebut = new DateTime($dateDebut);
        $dateFin = $dateFin;
    
        // Extraire les années et les mois
        $anneeDebut = (int) $dateDebut->format('Y');
        $moisDebut = (int) $dateDebut->format('m');
        $anneeFin = (int) $dateFin->format('Y');
        $moisFin = (int) $dateFin->format('m');
        // Calculer la différence totale en mois
        $diffMois = ($anneeFin - $anneeDebut) * 12 + ($moisFin - $moisDebut);
    
        return $diffMois;
    }
    
    public function pourcentage($id) {
        $personneMembre = $this->personneMembreRepository->getPersonne_LastCotisation($id);
        
        $diff100 = $this->differenceEnMois($personneMembre['date_inscription'] , new \DateTime());
        $diffpayer = $this->differenceEnMois($personneMembre['dernier_payement'] , new \DateTime());
        if( $diffpayer < 0){
            $diffpayer =  1;
        }
        if($diff100 == 0){
            $diff100 = 1;
        }
        $pourcentage = ($diffpayer * 100) / $diff100;
        return $pourcentage;
    }

    public function getDemanceMateriel_With_Investi()
    {
        $sql = 'SELECT DISTINCT dm.*,
       COALESCE(pc.date_de_payement, mp.date_inscription) AS date_de_payement,
       mp.date_inscription
FROM demande_materiel dm
LEFT JOIN validation_demande_materiel v ON dm.id = v.id_demande_materiel_id
LEFT JOIN payement_cotisation pc ON pc.id_personne_membre_id = dm.id_personne_membre_id
LEFT JOIN refuser_Demande_Materiel rm ON rm.id_demande_materiel_id = dm.id
JOIN personne_membre mp ON mp.id = dm.id_personne_membre_id
WHERE (pc.date_de_payement IS NULL
    OR pc.date_de_payement = (
        SELECT MAX(p.date_de_payement)
        FROM payement_cotisation p
        WHERE p.id_personne_membre_id = mp.id
        AND p.date_de_payement IS NOT NULL
    ))
AND v.id_demande_materiel_id IS NULL
AND rm.id_demande_materiel_id IS NULL;
';
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
}

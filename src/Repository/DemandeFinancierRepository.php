<?php

namespace App\Repository;

use App\Entity\DemandeFinancier;
use App\Entity\PersonneMembre;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeFinancier>
 */
class DemandeFinancierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry , private readonly PersonneMembreRepository $personneMembreRepository)
    {
        parent::__construct($registry, DemandeFinancier::class);
    }

    public function differenceEnMois($dateDebut, DateTime $dateFin) {
        $dateDebut = new DateTime($dateDebut);
        $dateFin = $dateFin;
    
        $anneeDebut = (int) $dateDebut->format('Y');
        $moisDebut = (int) $dateDebut->format('m');
        $anneeFin = (int) $dateFin->format('Y');
        $moisFin = (int) $dateFin->format('m');
        $diffMoisAvant = 12 - $moisDebut;
        $diffMoisAnnee = (($anneeFin) - ($anneeDebut+1) ) * 12 ;
        return $diffMoisAvant + $diffMoisAnnee + $moisFin;
        // return $anneeFin - 1;
    }
    
    public function pourcentage($id , PersonneMembreRepository $personneMembreRepository,DemandeFinancierRepository $demandeFinancierRepository) {
        $personneMembre = $personneMembreRepository->getPersonne_LastCotisation($id);
        $mois_total = $demandeFinancierRepository->differenceEnMois($personneMembre['date_inscription'] , new \DateTime());
        $mois_a_payer = $demandeFinancierRepository->differenceEnMois($personneMembre['dernier_payement'] , new \DateTime());
        if($mois_total == 0){
            return 0;
        }
        $diff =  $mois_total - $mois_a_payer ;
        $resultat =($diff * 100) / $mois_total;
        if($resultat > 100){
            $resultat = 100;
        }
        return $resultat;
    }
    public function rechercheDemandeFinancier($data, $montant, $dateDebut, $dateFin)
    {
        $sql = "SELECT dm.*, vdm.*, pm.* 
                FROM demande_financier dm
                JOIN validation_demande_financier vdm ON dm.id = vdm.id_demande_financier_id
                JOIN personne_membre pm ON pm.id = dm.id_personne_membre_id 
                WHERE 1=1";

        if ($data !== null) {
            $sql .= " AND (pm.nom_membre = '".$data."' OR pm.prenom_membre = '".$data."')";
        }
        if ($montant !== null) {
            $sql .= " AND dm.montant > ".$montant;
        }
        if ($dateDebut !== null && $dateFin !== null) {
            $sql .= " AND dm.date_demande_financier BETWEEN '".$dateDebut."' AND '".$dateFin."'";
        }
        if ($data == null && $montant == null && $dateDebut == null && $dateFin == null) {
            $sql .= " LIMIT 10";
        }

        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    // public function pourcentage1($id) {
    //     // Récupérer les informations de la personne membre
    //     $personneMembre = $this->personneMembreRepository->getPersonne_LastCotisation($id);
        
    //     // Vérifier si 'date_inscription' est un objet DateTime ou une chaîne de caractères
    //     $dateInscription = $personneMembre['date_inscription'];
    //     if (!$dateInscription instanceof \DateTime) {
    //         $dateInscription = new \DateTime($dateInscription);
            
    //     }
        
    //     // Vérifier si 'dernier_payement' est un objet DateTime ou une chaîne de caractères
    //     $dernierPayement = $personneMembre['dernier_payement'];
    //     if (!$dernierPayement instanceof \DateTime) {
    //         $dernierPayement = new \DateTime($dernierPayement);
    //     }
    //     // Calculer la différence en mois depuis l'inscription jusqu'à aujourd'hui
    //     $diff100 = $this->differenceEnMois($dateInscription->format('Y-m-d'), date('Y-m-d'));
        
    //     // Calculer la différence en mois depuis le dernier paiement jusqu'à aujourd'hui
    //     $diffpayer = $this->differenceEnMois($dernierPayement->format('Y-m-d'), date('Y-m-d'));
        
    //     // Calculer le pourcentage
        
    //     $pourcentage = ($diffpayer * 100) / $diff100;
        
    //     return $pourcentage;
    // }
    public function getDemanceFinancier_With_Investi()
    {
        $sql = '
    SELECT DISTINCT dm.*,
       COALESCE(pc.date_de_payement, mp.date_inscription) AS date_de_payement,
       mp.date_inscription
            FROM demande_financier dm
    LEFT JOIN validation_demande_financier v ON dm.id = v.id_demande_financier_id
    LEFT JOIN payement_cotisation pc ON pc.id_personne_membre_id = dm.id_personne_membre_id
    LEFT JOIN refuser_Demande_Financier rf ON rf.id_demande_financier_id = dm.id
    JOIN personne_membre mp ON mp.id = dm.id_personne_membre_id
        WHERE (pc.date_de_payement IS NULL
            OR pc.date_de_payement = (
                SELECT MAX(p.date_de_payement)
                FROM payement_cotisation p
                WHERE p.id_personne_membre_id = mp.id
                AND p.date_de_payement IS NOT NULL
       ))
        AND v.id_demande_financier_id IS NULL
        AND rf.id_demande_financier_id IS NULL;';
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return DemandeFinancier[] Returns an array of DemandeFinancier objects
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

    //    public function findOneBySomeField($value): ?DemandeFinancier
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\PayementCotisation;
use App\Entity\PersonneMembre;
use App\Entity\PrixCotisation;
use App\Service\Devis;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<PayementCotisation>
 */
class PayementCotisationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry , private readonly PersonneMembreRepository $personneMembreRepository  , private readonly PrixCotisationRepository $prixCotisationRepository , private readonly PrixChargeRepository $prixChargeRepository)
    {
        parent::__construct($registry, PayementCotisation::class);
    }
    public function addMois(\DateTime $date , int $months ): DateTime
    {
        $newDate = clone $date;
        $newDate->modify("+{$months} months");
        return $newDate;
    }
    public function Cotisation_Pers_Indep(int $id_personne, int $mois): array
    {
        $DevisList = [];
        $Perso = $this->personneMembreRepository->getPersonne_LastCotisation($id_personne);
        $PrixCotisation = new PrixCotisation();

        for ($i = 1; $i <= $mois; $i++) {
            $date_a_payer = $this->addMois(new \DateTime($Perso['dernier_payement']), $i);
            $prix = $this->prixCotisationRepository->getLastPrix_by_Date($date_a_payer);
            $Devis = new Devis();
            $Devis->setPersonnMembre($this->personneMembreRepository->find($id_personne));
            $Devis->setDatePayer($date_a_payer);
            $Devis->setMontant($prix['valeur']);
            $DevisList[] = $Devis;
        }

        return $DevisList;
    }
    public function Cotisation_Pers_Charge(int $id_personne, int $mois , int $id_Charge): array
    {
        $DevisList = [];
        $Perso_charge = [];
        
        if($id_Charge == 1){
            $Perso_charge = $this->personneMembreRepository->getPersonne_Couple($id_personne);
            for ($j = 0; $j < count($Perso_charge); $j++) {
                $Perso = $this->personneMembreRepository->getPersonne_LastCotisation($Perso_charge[$j]['idcouple']);
                $PrixCotisation = new PrixCotisation();
                for ($i = 1; $i <= $mois; $i++) {
                    $date_a_payer = $this->addMois(new \DateTime($Perso['dernier_payement']), $i);
                    $prix = $this->prixChargeRepository->getLastPrix_by_Date_by_idCharge($date_a_payer , $id_Charge);
                    $Devis = new Devis();
                    $Devis->setPersonnMembre($this->personneMembreRepository->find($Perso_charge[$j]['idcouple']));
                    $Devis->setDatePayer($date_a_payer);
                    $Devis->setMontant($prix['valeur']);
                    $DevisList[] = $Devis;
                }
            }
        }
        if($id_Charge == 2){
            $Perso_charge = $this->personneMembreRepository->getPersonne_Enfant($id_personne);
            for ($j = 0; $j < count($Perso_charge); $j++) {
                $Perso = $this->personneMembreRepository->getPersonne_LastCotisation($Perso_charge[$j]['idenfant']);
                $PrixCotisation = new PrixCotisation();
                for ($i = 1; $i <= $mois; $i++) {
                    $date_a_payer = $this->addMois(new \DateTime($Perso['dernier_payement']), $i);
                    $prix = $this->prixChargeRepository->getLastPrix_by_Date_by_idCharge($date_a_payer , $id_Charge);
                    $Devis = new Devis();
                    $Devis->setPersonnMembre($this->personneMembreRepository->find($Perso_charge[$j]['idenfant']));
                    $Devis->setDatePayer($date_a_payer);
                    $Devis->setMontant($prix['valeur']);
                    $DevisList[] = $Devis;
                }
            }
        }
        
        return $DevisList; 
    }
    public function Cotisation_Total(int $id_personne, int $mois ): array
    {
        $DevisList = [];
        $Pers_Responsable = $this->Cotisation_Pers_Indep($id_personne, $mois);
        $DevisList[] = $Pers_Responsable;
        $Perso_couple = $this->Cotisation_Pers_Charge($id_personne, $mois , 1);
        $DevisList[] = $Perso_couple;
        $Perso_Enfant = $this->Cotisation_Pers_Charge($id_personne, $mois , 2);
        $DevisList[] = $Perso_Enfant;
        return $DevisList;
    }
    public function getAllPayementCotisation()
    {
        $sql = "select * from payement_cotisation;";
        
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    public function getStatCotisation()
    {
        $sql = "SELECT 
            TO_CHAR(date_de_payement, 'YYYY-MM') AS mois, 
            SUM(montant_cotisation_total_payer) AS total_paye_par_mois
        FROM 
            payement_cotisation
        WHERE 
            date_de_payement >= NOW() - INTERVAL '7 months'
        GROUP BY 
            TO_CHAR(date_de_payement, 'YYYY-MM')
        ORDER BY 
            mois DESC";
        
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    public function getAllRecue($id, $annee = null)
    {
        $sql = 'SELECT pm.*, COALESCE(SUM(pc.montant_cotisation_total_payer), 0) as total
                FROM personne_membre pm
                LEFT JOIN payement_cotisation pc ON pm.id = pc.id_personne_membre_id
                WHERE pm.id = :id';
        
        if ($annee !== null) {
            $sql .= ' AND EXTRACT(YEAR FROM pc.date_payer) = :annee';
        }

        $sql .= ' GROUP BY pm.id';
        
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        
        if ($annee !== null) {
            $stmt->bindParam(':annee', $annee, \PDO::PARAM_INT);
        }

        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAssociative();
    }
    public function getAllRecueFamille($id, PersonneMembreRepository $personneMembreRepository): float  
    {
        $Famille = [];
        $Pers_Responsable = $this->getAllRecue($id);
        $Famille[] = $Pers_Responsable;
        $Vady = $personneMembreRepository->getPersonne_Couple($id);
        for ($j = 0; $j < count($Vady); $j++) {
            $Perso_couple = $this->getAllRecue($Vady[$j]['idcouple']);
            $Famille[] = $Perso_couple;
        }
        $Zanaka = $personneMembreRepository->getPersonne_Enfant($id);
        for ($k = 0; $k < count($Zanaka); $k++) {
            $personne_membre_zanaka = $this->getAllRecue($Zanaka[$k]['idenfant']);
            $Famille[] = $personne_membre_zanaka;
        }
        $total = 0;
        for ($i = 0; $i < count($Famille); $i++) {
            $total = $total + $Famille[$i]['total'];
        }
        return $total;
    }
    public function getAllRecueFamilleBy($id, $annee , PersonneMembreRepository $personneMembreRepository): float  
    {
        $Famille = [];
        $Pers_Responsable = $this->getAllRecue($id , $annee);
        $total = 0;
        if($Pers_Responsable != null){
            $Famille[] = $Pers_Responsable;
            $Vady = $personneMembreRepository->getPersonne_Couple($id);
            for ($j = 0; $j < count($Vady); $j++) {
                $Perso_couple = $this->getAllRecue($Vady[$j]['idcouple'] ,  $annee);
                $Famille[] = $Perso_couple;
            }
            $Zanaka = $personneMembreRepository->getPersonne_Enfant($id);
            for ($k = 0; $k < count($Zanaka); $k++) {
                $personne_membre_zanaka = $this->getAllRecue($Zanaka[$k]['idenfant'] , $annee);
                $Famille[] = $personne_membre_zanaka;
            }
            for ($i = 0; $i < count($Famille); $i++) {
                $total = $total + $Famille[$i]['total'];
            }
        }
        return $total;
    }

    
    
    public function rechercheCotisation($data, $village, $dataeDebut, $dataeFin)
    {
        $sql = "SELECT p.*, cp.* 
                FROM personne_membre p
                JOIN payement_cotisation cp ON p.id = cp.id_personne_membre_id 
                WHERE 1=1"; 

        if ($data !== null) {
            $sql .= " AND (p.nom_membre = '".$data."' OR p.prenom_membre = '".$data."' OR p.telephone = '".$data."')";
        }
        if ($village !== null) {
            $sql .= " AND p.id_village_id = ".$village;
        }
        if ($dataeDebut !== null && $dataeFin !== null) {
            $sql .= " AND cp.data_payer BETWEEN '".$dataeDebut."' AND '".$dataeFin."'";
        }
        if($data == null && $village == null && $dataeDebut == null && $dataeFin == null){
            $sql .= " LIMIT 10";
        }

        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }



    
    
    //    /**
    //     * @return PayementCotisation[] Returns an array of PayementCotisation objects
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

    //    public function findOneBySomeField($value): ?PayementCotisation
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

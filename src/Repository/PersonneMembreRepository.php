<?php

namespace App\Repository;

use App\Entity\Genre;
use App\Entity\PersonneMembre;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use League\Csv\Reader;

/**
 * @extends ServiceEntityRepository<PersonneMembre>
 */
class PersonneMembreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonneMembre::class);
    }
    public function GetMembreBySexe(Genre $genre){
        return $this->createQueryBuilder('personne')
            ->select('personne')
            ->where('Personne.Id_Genre = :Genre')
            ->setParameter('Genre',$genre)
            ->getQuery()
            ->getResult();
    }
    

    public function findPersonnesNonMariees()
    {
        $qb = $this->createQueryBuilder('pm')
            ->leftJoin('App\Entity\Mariage', 'm', 'WITH', 'm.Id_Mari = pm.id OR m.Id_Marie = pm.id')
            ->where('m.id IS NULL');

        return $qb->getQuery()->getResult();
    }


    public function getPersIndep()
    {
        $sql = 'WITH personne_marier AS (
            SELECT 
                CASE 
                    WHEN d_mari.id_personne_membre_id IS NULL THEN p_mari.id
                    WHEN d_marie.id_personne_membre_id IS NULL THEN p_marie.id
                    ELSE NULL
                END AS id_personne_marier_vivant
            FROM mariage m 
                LEFT JOIN personne_membre p_mari ON p_mari.id = m.id_mari_id
                LEFT JOIN personne_membre p_marie ON p_marie.id = m.id_marie_id
                LEFT JOIN decede d_mari ON p_mari.id = d_mari.id_personne_membre_id
                LEFT JOIN decede d_marie ON p_marie.id = d_marie.id_personne_membre_id
            WHERE d_mari.id_personne_membre_id IS NULL OR d_marie.id_personne_membre_id IS NULL
        )
        SELECT
            personne_membre.*,
            MAX(p_c.date_payer) AS dernier_payement,
            \'Marier\' AS situation
        FROM personne_membre 
            JOIN personne_marier p_m ON p_m.id_personne_marier_vivant = personne_membre.id
            LEFT JOIN payement_cotisation p_c ON p_c.id_personne_membre_id = personne_membre.id
        GROUP BY personne_membre.id
        UNION
        SELECT 
            p_m.*,
            MAX(p_c.date_payer) AS dernier_payement,
            \'Celibataire\' AS situation
        FROM personne_membre p_m
            LEFT JOIN mariage mari ON p_m.id = mari.id_mari_id OR p_m.id = mari.id_marie_id
            LEFT JOIN payement_cotisation p_c ON p_c.id_personne_membre_id = p_m.id
        WHERE mari.id_mari_id IS NULL 
        OR  mari.id_marie_id IS NULL
        AND EXTRACT(YEAR FROM AGE(date_de_naissance)) >= 21
        GROUP BY p_m.id;';

        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    public function getPersIndepNotUser()
{
    // Requête SQL
    $sql = '
        WITH personne_marier AS (
            SELECT 
                CASE 
                    WHEN d_mari.id_personne_membre_id IS NULL THEN p_mari.id
                    WHEN d_marie.id_personne_membre_id IS NULL THEN p_marie.id
                    ELSE NULL
                END AS id_personne_marier_vivant
            FROM mariage m
            LEFT JOIN personne_membre p_mari ON p_mari.id = m.id_mari_id
            LEFT JOIN personne_membre p_marie ON p_marie.id = m.id_marie_id
            LEFT JOIN decede d_mari ON p_mari.id = d_mari.id_personne_membre_id
            LEFT JOIN decede d_marie ON p_marie.id = d_marie.id_personne_membre_id
            WHERE d_mari.id_personne_membre_id IS NULL 
            OR d_marie.id_personne_membre_id IS NULL
        )

        SELECT 
            pm.*, 
            MAX(p_c.date_payer) AS dernier_payement, 
            \'Marier\' AS situation
        FROM personne_membre pm
        JOIN personne_marier p_m ON p_m.id_personne_marier_vivant = pm.id
        LEFT JOIN payement_cotisation p_c ON p_c.id_personne_membre_id = pm.id
        LEFT JOIN users u ON u.id_personne_id = pm.id  
        LEFT JOIN quitte q ON q.id_personne_membre_id = pm.id
        WHERE u.id_personne_id IS NULL
        AND q.id_personne_membre_id IS NULL  
        GROUP BY pm.id

        UNION

        SELECT 
            pm.*, 
            MAX(p_c.date_payer) AS dernier_payement, 
            \'Celibataire\' AS situation
        FROM personne_membre pm
        LEFT JOIN mariage mari ON pm.id = mari.id_mari_id OR pm.id = mari.id_marie_id
        LEFT JOIN payement_cotisation p_c ON p_c.id_personne_membre_id = pm.id
        LEFT JOIN users u ON u.id_personne_id = pm.id  
        LEFT JOIN quitte q ON q.id_personne_membre_id = pm.id
        WHERE (mari.id_mari_id IS NULL OR pm.id = mari.id_marie_id)
        AND EXTRACT(YEAR FROM AGE(pm.date_de_naissance)) >= 21  
        AND u.id_personne_id IS NULL
        AND q.id_personne_membre_id IS NULL  
        GROUP BY pm.id;
    ';

    // Connexion à la base de données
    $conn = $this->getEntityManager()->getConnection();
    
    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    
    // Exécution de la requête
    $resultSet = $stmt->executeQuery();
    
    // Retourne les résultats sous forme de tableau associatif
    return $resultSet->fetchAllAssociative();
}

    public function getPersNotQuitte()
    {
        $sql = '
            select pm.* from personne_membre pm
                LEFT join quitte q on q.id_personne_membre_id=pm.id
            where q.id_personne_membre_id is NULL;
        ';

        $conn = $this->getEntityManager()->getConnection();
        
        // Préparation de la requête
        $stmt = $conn->prepare($sql);
        
        // Exécution de la requête
        $resultSet = $stmt->executeQuery();
        
        // Retourne les résultats sous forme de tableau associatif
        return $resultSet->fetchAllAssociative();
    }


    public function getPersonne_LastCotisation(int $id_personne)
    {
        $sql = 'SELECT 
                p_m.*,
                Coalesce(MAX(p_c.date_payer) , p_m.date_inscription) as dernier_payement
            FROM personne_membre p_m
                LEFT JOIN payement_cotisation p_c ON p_c.id_personne_membre_id=p_m.id
            WHERE p_m.id='.$id_personne.'
            GROUP BY p_m.id'; 
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAssociative();
    }

    public function  getPersonne_Couple(int $id_personne)
    {
        $sql = 'SELECT 
    CASE 
        WHEN p_mari.id = :id_personne THEN p_marie.id
        WHEN p_marie.id = :id_personne THEN p_mari.id 
    END as idCouple
        FROM mariage m   
            JOIN personne_membre p_mari ON p_mari.id = m.id_mari_id
            JOIN personne_membre p_marie ON p_marie.id = m.id_marie_id
        WHERE :id_personne IN (p_mari.id, p_marie.id)
        AND NOT EXISTS (
                        SELECT :id_personne 
                        FROM decede d 
                        WHERE (p_mari.id = :id_personne AND d.id_personne_membre_id = p_marie.id) 
                        OR (p_marie.id = :id_personne AND d.id_personne_membre_id = p_mari.id)
                    );';
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('id_personne', $id_personne);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    public function getPersonne_Enfant(int $id_personne)
    {
        $sql = 'SELECT 
                e.id_enfant_id AS idEnfant
                FROM  enfant e
                    JOIN  mariage m ON e.id_mariage_parent_id = m.id
                    JOIN  personne_membre p ON e.id_enfant_id = p.id
                WHERE EXTRACT(YEAR FROM AGE(p.date_de_naissance)) <21
                AND m.id_mari_id = :id_personne OR m.id_marie_id = :id_personne;';
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('id_personne', $id_personne);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }
    public function getStatPersonne()
    {
        $sql = "SELECT 
    DATE_TRUNC('month', date_inscription) AS mois,
    COUNT(*) AS nombre_personnes
FROM 
    personne_membre
WHERE 
    date_inscription >= CURRENT_DATE - INTERVAL '7 months'
GROUP BY 
    DATE_TRUNC('month', date_inscription)
ORDER BY 
    mois;
";
        
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

    public function PersonneCharge_ByResposanble(int $id_personne): array
    {
        $Famille = [];
        $Resposable = $this->find($id_personne);
        $Famille[] = $Resposable;
        $Vady = $this->getPersonne_Couple($id_personne);
        for ($j = 0; $j < count($Vady); $j++) {
            $personne_membre_vady = $this->find($Vady[$j]['idcouple']);
            $Famille[] = $personne_membre_vady;
        }
        $Zanaka = $this->getPersonne_Enfant($id_personne);
        for ($k = 0; $k < count($Zanaka); $k++) {
            $personne_membre_zanaka = $this->find($Zanaka[$k]['idenfant']);
            $Famille[] = $personne_membre_zanaka;
        }
        return $Famille;
    }
    //    /**
    //     * @return PersonneMembre[] Returns an array of PersonneMembre objects
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

    //    public function findOneBySomeField($value): ?PersonneMembre
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\OffreEmplois;
use App\Entity\Profession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<OffreEmplois>
 */
class OffreEmploisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreEmplois::class);
    }

    public function findOffre()
{
    $sql = 'SELECT 
        o.id, o.profession_id, o.personne_membre_id, o.description, o.date_offre, o.titre,
        p.id AS personne_id, p.id_village_id, p.id_genre_id, p.nom_membre, p.date_de_naissance, 
        p.address, p.email, p.prenom_membre, p.date_inscription, p.fokotany, p.address_tana, 
        p.cin, p.arrondissement, pr.nom_profession,
        STRING_AGG(t.telephone, \', \') AS telephones
    FROM offre_emplois o
    LEFT JOIN personne_membre p ON p.id = o.personne_membre_id
    LEFT JOIN telephone t ON t.id_personne_membre_id = p.id
    LEFT JOIN profession pr ON pr.id = o.profession_id
    GROUP BY o.id, o.profession_id, o.personne_membre_id, o.description, o.date_offre, o.titre,
             p.id, p.id_village_id, p.id_genre_id, p.nom_membre, p.date_de_naissance, 
             p.address, p.email, p.prenom_membre, p.date_inscription, p.fokotany, p.address_tana, 
             p.cin, p.arrondissement, pr.nom_profession
    ORDER BY o.date_offre DESC';

    $conn = $this->getEntityManager()->getConnection();
    $stmt = $conn->prepare($sql);
    $resultSet = $stmt->executeQuery();
    
    return $resultSet->fetchAllAssociative();
}



public function findByTitreOrProfession(?string $titre, ?int $professionId): array
{
    $sql = 'SELECT 
        o.id, o.profession_id, o.personne_membre_id, o.description, o.date_offre, o.titre,
        p.id AS personne_id, p.id_village_id, p.id_genre_id, p.nom_membre, p.date_de_naissance, 
        p.address, p.email, p.prenom_membre, p.date_inscription, p.fokotany, p.address_tana, 
        p.cin, p.arrondissement, pr.nom_profession, 
        STRING_AGG(t.telephone, \', \') AS telephones
    FROM offre_emplois o
    LEFT JOIN personne_membre p ON p.id = o.personne_membre_id
    LEFT JOIN telephone t ON t.id_personne_membre_id = p.id
    LEFT JOIN profession pr ON pr.id = o.profession_id';
    
    $conditions = [];
    
    if ($titre !== null && $titre !== '') {
        $conditions[] = 'o.titre LIKE :titre';
    }
    
    if ($professionId !== null) {
        $conditions[] = 'o.profession_id = :profession_id';
    }
    
    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' OR ', $conditions);
    }
    
    $sql .= ' GROUP BY o.id, o.profession_id, o.personne_membre_id, o.description, o.date_offre, o.titre,
              p.id, p.id_village_id, p.id_genre_id, p.nom_membre, p.date_de_naissance, 
              p.address, p.email, p.prenom_membre, p.date_inscription, p.fokotany, p.address_tana, 
              p.cin, p.arrondissement, pr.nom_profession
              ORDER BY o.date_offre DESC';
    
    $conn = $this->getEntityManager()->getConnection();
    $stmt = $conn->prepare($sql);
    
    if ($titre !== null && $titre !== '') {
        $stmt->bindValue('titre', '%' . $titre . '%');
    }
    if ($professionId !== null) {
        $stmt->bindValue('profession_id', $professionId);
    }
    
    $resultSet = $stmt->executeQuery();
    
    return $resultSet->fetchAllAssociative();
}




    //    /**
    //     * @return OffreEmplois[] Returns an array of OffreEmplois objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OffreEmplois
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\Mariage;
use App\Entity\PersonneMembre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mariage>
 */
class MariageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mariage::class);
    }
    public function getMariageByPere(PersonneMembre $IdMari){
        return $this->createQueryBuilder('mariage')
            ->select('mariage')
            ->where('mariage.Id_Mari = :IdMari')
            ->setParameter('IdMari',$IdMari)
            ->getQuery()
            ->getResult();
    }

    public function findMariagesWithChildrenCount()
    {
        return $this->getEntityManager()
        ->createQuery('
            SELECT m.id, COUNT(e.id) as children_count
            FROM App\Entity\Mariage m
            LEFT JOIN App\Entity\Enfant e WITH e.Id_Mariage_Parent = m.id
            GROUP BY m.id
        ')
        ->getResult();
    }
    public function getPersonne_parent()
    {
        $sql = 'SELECT m.id ,  pm.id as Idmari , pm.nom_membre as Nommari, pm.prenom_membre as Pernommari , pme.id as Idmarie , pme.nom_membre as Nommarie , pme.prenom_membre as Prenommarie
    from mariage m
    JOIN personne_membre pm on pm.id = m.id_mari_id
    JOIN personne_membre pme on pme.id = m.id_marie_id;';
        $conn = $this->getEntityManager()->getConnection();
        
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return Mariage[] Returns an array of Mariage objects
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

//    public function findOneBySomeField($value): ?Mariage
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

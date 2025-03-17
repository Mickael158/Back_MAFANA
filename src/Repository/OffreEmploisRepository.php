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

    public function findOffre(SerializerInterface $serializer)
{
    $offres = $this->createQueryBuilder('o')
        ->select('o', 'p', 't')
        ->leftJoin('o.PersonneMembre', 'p')
        ->leftJoin('p.telephones', 't')
        ->orderBy('o.DateOffre', 'DESC')
        ->getQuery()
        ->getResult();
        
        return $serializer->serialize($offres, 'json', ['groups' => 'personne_read']);
}


    public function findByTitreOrProfession(?string $titre, ?int $professionId): array
    {
        $entity = $this->find($professionId);
        $qb = $this->createQueryBuilder('o');

        if ($titre) {
            $qb->orWhere('o.Titre LIKE :titre')
               ->setParameter('titre', '%' . $titre . '%');
        }

        if ($entity) {
            $qb->orWhere('o.Profession = :profession')
               ->setParameter('profession', $professionId);
        }

        return $qb->getQuery()->getResult();
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

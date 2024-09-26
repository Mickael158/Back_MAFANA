<?php

namespace App\Repository;

use App\Entity\Association;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Association>
 */
class AssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Association::class);
    }
    function envoyerEmail($emailExpediteur, $emailDestinataire, $sujet, $message) {
        // Construction des en-têtes de l'email
        $headers = 'From: ' . $emailExpediteur . "\r\n" .  // Spécifie l'expéditeur de l'email
                   'Reply-To: ' . $emailExpediteur . "\r\n" .  // Spécifie à qui répondre (généralement l'expéditeur)
                   'X-Mailer: PHP/' . phpversion();  // Indique que l'email a été envoyé via PHP
    
        // Utilisation de la fonction mail() de PHP pour envoyer l'email
        $envoye = mail($emailDestinataire, $sujet, $message, $headers);
    
        // Vérifie si l'email a été envoyé correctement
        if ($envoye) {
            echo "Email envoyé avec succès à $emailDestinataire.";  // Si l'email est envoyé
        } else {
            echo "Échec de l'envoi de l'email.";  // Si l'envoi échoue
        }
    }
    //    /**
    //     * @return Association[] Returns an array of Association objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Association
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

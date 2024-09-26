<?php

namespace App\Service;

use App\Entity\Tresoreri;
use App\Repository\TresoreriRepository;
use Doctrine\ORM\EntityManagerInterface;

class TresorerieService{

    public function __construct(private readonly TresoreriRepository $tresoreriRepository,private readonly EntityManagerInterface $em)
    {
        
    }
    public function insert(float $Montant){
        $tresorerie = new Tresoreri();
        $lastTresorerie = $this->tresoreriRepository->LastTresoreri();
        $lastMontant = 0;
        if($lastTresorerie){
            $lastMontant = $lastTresorerie['montant'];
        }
        $lastMontant = $lastMontant + $Montant;
        $tresorerie
            ->setMontant($lastMontant)
            ->setDateTresoreri(new \DateTime());
        $this->em->persist($tresorerie);
        $this->em->flush();
    }
    public function insertMoins(float $Montant){
        $tresorerie = new Tresoreri();
        $lastTresorerie = $this->tresoreriRepository->LastTresoreri();
        $lastMontant = 0;
        if($lastTresorerie){
            $lastMontant = $lastTresorerie['montant'];
        }
        $lastMontant = $lastMontant - $Montant;
        $tresorerie
            ->setMontant($lastMontant)
            ->setDateTresoreri(new \DateTime());
        $this->em->persist($tresorerie);
        $this->em->flush();
    }
}
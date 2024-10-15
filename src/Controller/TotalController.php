<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\ValleeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TotalController extends AbstractController
{
    #[Route('/api/Valle_Total',name:'Valle_Total',methods:'GET')]
    public function TotalValle(ValleeRepository $valleeRepository){
        $nb = count($valleeRepository->findAll());
        return $this->json($nb, 200, []);
    }

    #[Route('/api/Personne_Total',name:'Personne_Total',methods:'GET')]
    public function TotalPersonne(PersonneMembreRepository $personneMembreRepository){
        $nb = count($personneMembreRepository->findAll());
        return $this->json($nb, 200, []);
    }

    #[Route('/api/Evenement_Total',name:'Evnement_Total',methods:'GET')]
    public function TotalEvenement(EvenementRepository $evenementRepository){
        $nb = count($evenementRepository->findAll());
        return $this->json($nb, 200, []);
    }
}
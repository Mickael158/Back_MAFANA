<?php
    namespace App\Controller;

use App\Repository\DonationFinancierRepository;
use App\Repository\PayementCotisationRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\TresoreriRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class StatistiqueController extends AbstractController{
        #[Route('/api/StatTresoreri',name:'selectStatTresoreri',methods:'GET')]
        public function StatTresoreri(TresoreriRepository $tresoreriRepository){
            return $this->json($tresoreriRepository->getStatTresoreri(), 200, []);
        }
        #[Route('/api/StatCotisation',name:'selectStatCotisation',methods:'GET')]
        public function StatCotisation(PayementCotisationRepository $payementCotisationRepository){
            return $this->json($payementCotisationRepository->getStatCotisation(), 200, []);
        }
        #[Route('/api/StatDonnation',name:'selectStatDonnation',methods:'GET')]
        public function StatDonnation(DonationFinancierRepository $donationFinancierRepository){
            return $this->json($donationFinancierRepository->getStatDonnation(), 200, []);
        }
        #[Route('/api/StatPersonne',name:'selectStatPersonne',methods:'GET')]
        public function StatPersonne(PersonneMembreRepository $personneMembreRepository){
            return $this->json($personneMembreRepository->getStatPersonne(), 200, []);
        }
    }
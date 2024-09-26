<?php
namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetEvenementController extends AbstractController{

    #[Route('/api/Evenement/proche_evenement',name:'select3_proche_evenement',methods:'GET')]
        public function select3_proche_evenement(EvenementRepository $EvenementRepository):JsonResponse
        {
            return $this->json($EvenementRepository->get3_proche_evenement(), 200, []);
        }
}

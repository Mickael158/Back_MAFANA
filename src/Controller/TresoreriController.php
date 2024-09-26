<?php
    namespace App\Controller;

use App\Entity\Tresoreri;
use App\Repository\TresoreriRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class TresoreriController extends AbstractController{

        #[Route('/api/Tresoreri',name:'selectAll_Tresoreri',methods:'GET')]
        public function selectAll(TresoreriRepository $TresoreriRepository){
            return $this->json($TresoreriRepository->LastTresoreri(), 200, []);
        }

        #[Route('/api/Tresoreri/{id}',name:'selectId_Tresoreri',methods:'GET')]
        public function selectById($id,TresoreriRepository $TresoreriRepository){
            return $this->json($TresoreriRepository->find($id), 200, []);
        }
    }
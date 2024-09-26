<?php
    namespace App\Controller;

use App\Entity\PrixCharge;
use App\Repository\ChargeRepository;
use App\Repository\PrixChargeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class PrixChargeController extends AbstractController{

        #[Route('/api/PrixCharge',name:'insetion_PrixCharge',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em , ChargeRepository $chargeRepository){
            $PrixCharge = new PrixCharge();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Charge = $chargeRepository->find($data_decode['idCharge']);
            $PrixCharge->setIdCharge($Charge)
                        ->setValeur($data_decode['Valeur'])
                        ->setDateInsertionPrixCharge(new \DateTime($data_decode['DateInsertionPrixCharge']));
            $em->persist($PrixCharge);
            $em->flush();
            return $this->json(['message' => 'Prix Charge inserer'], 200, []);
        }

        

        #[Route('/api/PrixCharge',name:'selectAll_PrixCharge',methods:'GET')]
        public function selectAll(PrixChargeRepository $PrixChargeRepository){
            return $this->json($PrixChargeRepository->findAll(), 200, []);
        }

        #[Route('/api/PrixCharge/{id}',name:'selectId_PrixCharge',methods:'GET')]
        public function selectById($id,PrixChargeRepository $PrixChargeRepository){
            return $this->json($PrixChargeRepository->find($id), 200, []);
        }
        #[Route('/api/selectPrixLastByDateByIdCharge',name:'selectId_PrixCharge',methods:'GET')]
        public function selectPrixLastByDateByIdCharge(PrixChargeRepository $PrixChargeRepository){
            $date = new \DateTime();
            $idCharge = 1;
            return $this->json($PrixChargeRepository->getLastPrix_by_Date_by_idCharge($date , $idCharge));
        }
    }
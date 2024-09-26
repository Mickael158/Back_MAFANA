<?php
    namespace App\Controller;

use App\Entity\Charge;
use App\Repository\ChargeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class ChargeController extends AbstractController{

        #[Route('/api/Charge',name:'insetion_Charge',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em){
            $Charge = new Charge();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Charge->setNomCharge($data_decode['Nom_Charge']);
            $em->persist($Charge);
            $em->flush();
            return $this->json(['message' => 'Charge inserer'], 200, []);
        }

        #[Route('/api/Charge/{id}',name:'modification_Charge',methods:'POST')]
        public function modifier(Charge $Charge,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Charge->setNomCharge($data_decode['Nom_Charge']);
            $em->flush();
            return $this->json(['message' => 'Charge modifier'], 200, []);
        }

        #[Route('/api/Charge/supprimer/{id}',name:'suppresseion_Charge',methods:'POST')]
        public function supprimer(Charge $Charge,Request $request, EntityManagerInterface $em){
            $em->remove($Charge);
            $em->flush();
            return $this->json(['message' => 'Charge Supprimer'], 200, []);
        }

        #[Route('/api/Selects',name:'selectAll_Charges',methods:'GET')]
        public function selectAlls(ChargeRepository $ChargeRepository){
            return $this->json($ChargeRepository->findAll(), 200, []);
        }

        #[Route('/api/Charge/{id}',name:'selectId_Charge',methods:'GET')]
        public function selectById($id,ChargeRepository $ChargeRepository){
            return $this->json($ChargeRepository->find($id), 200, []);
        }
    }
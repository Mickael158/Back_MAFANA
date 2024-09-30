<?php
    namespace App\Controller;

use App\Entity\Village;
use App\Repository\ValleeRepository;
use App\Repository\VillageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class VillageController extends AbstractController{

        #[Route('/api/village',name:'insetion_village',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em,ValleeRepository $valleeRepository){
            $village = new Village();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $valle = $valleeRepository->find($data_decode['Id_vallee']);            
            $village->setNomVillage($data_decode['Nom_village']);
            $village->setIdVallee($valle);
            $em->persist($village);
            $em->flush();
            return $this->json(['message' => 'Village inserer'], 200, []);
        }

        #[Route('/api/village/{id}',name:'modification_village',methods:'POST')]
        public function modifier(Village $village,Request $request, EntityManagerInterface $em , ValleeRepository $valleeRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $valle = $valleeRepository->find($data_decode['Id_vallee']);
            $village->setNomVillage($data_decode['Nom_village']);
            $village->setIdVallee($valle);
            $em->flush();
            return $this->json(['message' => 'Village modifier'], 200, []);
        }

        #[Route('/api/village/supprimer/{id}',name:'suppresseion_village',methods:'DELETE')]
        public function supprimer(Village $village,Request $request, EntityManagerInterface $em){
            $em->remove($village);
            $em->flush();
            return $this->json(['message' => 'Village Supprimer'], 200, []);
        }

        #[Route('/api/village',name:'selectAll_village',methods:'GET')]
        public function selectAll(VillageRepository $villageeRepository){
            return $this->json($villageeRepository->findAll(), 200, []);
        }

        #[Route('/api/village/{id}',name:'selectId_village',methods:'GET')]
        public function selectById($id,VillageRepository $villageeRepository){
            return $this->json($villageeRepository->find($id), 200, []);
        }
    }
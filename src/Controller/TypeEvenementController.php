<?php
    namespace App\Controller;

use App\Entity\TypeEvenement;
use App\Repository\TypeEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class TypeEvenementController extends AbstractController{

        #[Route('/api/TypeEvenement',name:'insetion_TypeEvenement',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em){
            $TypeEvenement = new TypeEvenement();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $TypeEvenement->setNomTypeEvenement($data_decode['Nom_Type_Evenement']);
            $em->persist($TypeEvenement);
            $em->flush();
            return $this->json(['message' => 'Type Evenement inserer'], 200, []);
        }

        #[Route('/api/TypeEvenement/{id}',name:'modification_TypeEvenement',methods:'POST')]
        public function modifier(TypeEvenement $TypeEvenement,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $TypeEvenement->setNomTypeEvenement($data_decode['Nom_Type_Evenement']);
            $em->flush();
            return $this->json(['message' => 'Type Evenement modifier'], 200, []);
        }

        #[Route('/api/TypeEvenement/supprimer/{id}',name:'suppresseion_TypeEvenement',methods:'POST')]
        public function supprimer(TypeEvenement $TypeEvenement,Request $request, EntityManagerInterface $em){
            $em->remove($TypeEvenement);
            $em->flush();
            return $this->json(['message' => 'Type Evenement Supprimer'], 200, []);
        }

        #[Route('/api/TypeEvenement',name:'selectAll_TypeEvenement',methods:'GET')]
        public function selectAll(TypeEvenementRepository $TypeEvenementRepository){
            return $this->json($TypeEvenementRepository->findAll(), 200, []);
        }

        #[Route('/api/TypeEvenement/{id}',name:'selectId_TypeEvenement',methods:'GET')]
        public function selectById($id,TypeEvenementRepository $TypeEvenementRepository){
            return $this->json($TypeEvenementRepository->find($id), 200, []);
        }
    }
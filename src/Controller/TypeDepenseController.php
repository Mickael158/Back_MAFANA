<?php
    namespace App\Controller;

use App\Entity\TypeDepense;
use App\Repository\TypeDepenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class TypeDepenseController extends AbstractController
    {

        #[Route('/api/TypeDepense',name:'insetion_TypeDepense',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em){
            $TypeDepense = new TypeDepense();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $TypeDepense->setMotifDepense($data_decode['Motif_Depense']);
            $em->persist($TypeDepense);
            $em->flush();
            return $this->json(['message' => 'Type Depense inserer'], 200, []);
        }

        #[Route('/api/TypeDepense/{id}',name:'modification_TypeDepense',methods:'POST')]
        public function modifier(TypeDepense $TypeDepense,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $TypeDepense->setMotifDepense($data_decode['Motif_Depense']);
            $em->flush();
            return $this->json(['message' => 'Type Depense modifier'], 200, []);
        }

        #[Route('/api/TypeDepense/supprimer/{id}',name:'suppresseion_TypeDepense',methods:'DELETE')]
        public function supprimer(TypeDepense $TypeDepense,Request $request, EntityManagerInterface $em){
            $em->remove($TypeDepense);
            $em->flush();
            return $this->json(['message' => 'Type Depense Supprimer'], 200, []);
        }

        #[Route('/api/TypeDepense',name:'selectAll_TypeDepense',methods:'GET')]
        public function selectAll(TypeDepenseRepository $TypeDepenseRepository){
            return $this->json($TypeDepenseRepository->findAll(), 200, []);
        }

        #[Route('/api/TypeDepense/{id}',name:'selectId_TypeDepense',methods:'GET')]
        public function selectById($id,TypeDepenseRepository $TypeDepenseRepository){
            return $this->json($TypeDepenseRepository->find($id), 200, []);
        }
    }
<?php
    namespace App\Controller;

use App\Entity\TypeRevenu;
use App\Repository\TypeRevenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_CRUD")'))]
    class TypeRevenuController extends AbstractController{

        #[Route('/api/TypeRevenu',name:'insetion_TypeRevenu',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em){
            $TypeRevenu = new TypeRevenu();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $TypeRevenu->setMotifRevenu($data_decode['motif_revenu']);
            $em->persist($TypeRevenu);
            $em->flush();
            return $this->json(['message' => 'Type Revenu inserer'], 200, []);
        }

        #[Route('/api/TypeRevenu/{id}',name:'modification_TypeRevenu',methods:'POST')]
        public function modifier(TypeRevenu $TypeRevenu,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $TypeRevenu->setMotifRevenu($data_decode['motif_revenu']);
            $em->flush();
            return $this->json(['message' => 'Type Revenu modifier'], 200, []);
        }

        #[Route('/api/TypeRevenu/supprimer/{id}',name:'suppresseion_TypeRevenu',methods:'DELETE')]
        public function supprimer(TypeRevenu $TypeRevenu,Request $request, EntityManagerInterface $em){
            $em->remove($TypeRevenu);
            $em->flush();
            return $this->json(['message' => 'Type Revenu Supprimer'], 200, []);
        }

        #[Route('/api/TypeRevenu',name:'selectAll_TypeRevenu',methods:'GET')]
        public function selectAll(TypeRevenuRepository $TypeRevenuRepository){
            return $this->json($TypeRevenuRepository->findAll(), 200, []);
        }

        #[Route('/api/TypeRevenu/{id}',name:'selectId_TypeRevenu',methods:'GET')]
        public function selectById($id,TypeRevenuRepository $TypeRevenuRepository){
            return $this->json($TypeRevenuRepository->find($id), 200, []);
        }
    }
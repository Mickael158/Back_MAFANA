<?php
    namespace App\Controller;

use App\Entity\Vallee;
use App\Repository\ValleeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class ValleController extends AbstractController{

        #[Route('/api/valle',name:'insetion_valle',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em){
            $valle = new Vallee();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $valle->setNomVallee($data_decode['Nom_valle']);
            $em->persist($valle);
            $em->flush();
            return $this->json(['message' => 'Valle inserer'], 200, []);
        }

        #[Route('/api/valle/{id}',name:'modification_valle',methods:'POST')]
        public function modifier(Vallee $valle,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $valle->setNomVallee($data_decode['Nom_valle']);
            $em->flush();
            return $this->json(['message' => 'Valle modifier'], 200, []);
        }

        #[Route('/api/valle/supprimer/{id}',name:'suppresseion_valle',methods:'DELETE')]
        public function supprimer(Vallee $valle,Request $request, EntityManagerInterface $em){
            $em->remove($valle);
            $em->flush();
            return $this->json(['message' => 'Valle Supprimer'], 200, []);
        }

        #[Route('/api/valle',name:'selectAll_valle',methods:'GET')]
        public function selectAll(ValleeRepository $valleeRepository){
            return $this->json($valleeRepository->findAll(), 200, []);
        }

        #[Route('/api/valle/{id}',name:'selectId_valle',methods:'GET')]
        public function selectById($id,ValleeRepository $valleeRepository){
            return $this->json($valleeRepository->find($id), 200, []);
        }
    }
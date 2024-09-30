<?php
    namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class RoleController extends AbstractController{

        #[Route('/api/Role',name:'insetion_Role',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em){
            $Role = new Role();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Role->setNomRole($data_decode['Nom_Role']);
            $em->persist($Role);
            $em->flush();
            return $this->json(['message' => 'Role inserer'], 200, []);
        }

        #[Route('/api/Role/{id}',name:'modification_Role',methods:'POST')]
        public function modifier(Role $Role,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Role->setNomRole($data_decode['Nom_Role']);
            $em->flush();
            return $this->json(['message' => 'Role modifier'], 200, []);
        }

        #[Route('/api/Role/supprimer/{id}',name:'suppresseion_Role',methods:'DELETE')]
        public function supprimer(Role $Role,Request $request, EntityManagerInterface $em){
            $em->remove($Role);
            $em->flush();
            return $this->json(['message' => 'Role Supprimer'], 200, []);
        }

        #[Route('/api/Role',name:'selectAll_Role',methods:'GET')]
        public function selectAll(RoleRepository $RoleRepository){
            return $this->json($RoleRepository->findAll(), 200, []);
        }

        #[Route('/api/Role/{id}',name:'selectId_Role',methods:'GET')]
        public function selectById($id,RoleRepository $RoleRepository){
            return $this->json($RoleRepository->find($id), 200, []);
        }
    }
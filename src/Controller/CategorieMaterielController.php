<?php
    namespace App\Controller;

use App\Entity\CategorieMateriel;
use App\Repository\CategorieMaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_CRUD")'))]
    class CategorieMaterielController extends AbstractController{

        #[Route('/api/Categorie',name:'insetion_Categorie',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em){
            $Categorie = new CategorieMateriel();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Categorie->setNomCategorie($data_decode['Nom_Categorie']);
            $em->persist($Categorie);
            $em->flush();
            return $this->json(['message' => 'Categorie inserer'], 200, []);
        }

        #[Route('/api/Categorie/{id}',name:'modification_Categorie',methods:'POST')]
        public function modifier(CategorieMateriel $Categorie,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Categorie->setNomCategorie($data_decode['Nom_Categorie']);
            $em->flush();
            return $this->json(['message' => 'Categorie modifier'], 200, []);
        }

        #[Route('/api/Categorie/supprimer/{id}',name:'suppresseion_Categorie',methods:'DELETE')]
        public function supprimer(CategorieMateriel $Categorie,Request $request, EntityManagerInterface $em){
            $em->remove($Categorie);
            $em->flush();
            return $this->json(['message' => 'Categorie Supprimer'], 200, []);
        }

        #[Route('/api/Categories',name:'selectAll_Categories',methods:'GET')]
        public function selectAll(CategorieMaterielRepository $CategorieMaterielRepository){
            return $this->json($CategorieMaterielRepository->findAll(), 200, []);
        }

        #[Route('/api/Categorie/{id}',name:'selectId_Categorie',methods:'GET')]
        public function selectById($id,CategorieMaterielRepository $CategorieMaterielRepository){
            return $this->json($CategorieMaterielRepository->find($id), 200, []);
        }
    }
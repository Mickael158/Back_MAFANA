<?php
namespace App\Controller;

use App\Entity\Materiel;
use App\Repository\CategorieMaterielRepository;
use App\Repository\MaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class MaterielController extends AbstractController
{
    #[Route('/api/Materiel',name:'api_materiel',methods:'POST')]
    public function inerer(Request $request,EntityManagerInterface $em,CategorieMaterielRepository $categorieMaterielRepository):JsonResponse
    {
        $data = $request->getContent();
        $data_decode = json_decode($data, true);
        $Categorie = $categorieMaterielRepository->find($data_decode['Id_Categorie_Materiel']);
        $Materiel = new Materiel();
        $Materiel
            ->setNomMateriel($data_decode['Nom_Materiel'])
            ->setIdCategorieMateriel($Categorie);
        $em->persist($Materiel);
        $em->flush();
        return $this->json($Materiel,200,[]);
    }

        #[Route('/api/Materiel',name:'selectAll_Materiel',methods:'GET')]
        public function selectAll(MaterielRepository $MaterielRepository){
            return $this->json($MaterielRepository->findAll(), 200, []);
        }

        #[Route('/api/Materiel/{id}',name:'modification_Materiel',methods:'POST')]
        public function modifier(Materiel $Materiel,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Materiel->setNomMateriel($data_decode['Nom_Materiel']);
            $em->flush();
            return $this->json(['message' => 'Materiel modifier'], 200, []);
        }

        #[Route('/api/Materiel/supprimer/{id}',name:'suppresseion_Materiel',methods:'POST')]
        public function supprimer(Materiel $Materiel,Request $request, EntityManagerInterface $em){
            $em->remove($Materiel);
            $em->flush();
            return $this->json(['message' => 'Materiel Supprimer'], 200, []);
        }
        #[Route('/api/Materiel/existantDon',name:'existantDon',methods:'GET')]
        public function existantDon(MaterielRepository $materielRepository){
            return $this->json($materielRepository->getMaterielExistant(), 200, []);
        }
}
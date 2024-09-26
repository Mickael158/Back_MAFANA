<?php
namespace App\Controller;

use App\Entity\Mariage;
use App\Repository\EnfantRepository;
use App\Repository\MariageRepository;
use App\Repository\PersonneMembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class MariageController extends AbstractController{

    #[Route('/api/Mariage',name:'Nouveau_marier',methods:'POST')]
    public function inserer(Request $request,EntityManagerInterface $em,PersonneMembreRepository $personneRepository){
        $mariage = new Mariage();
        $data = $request->getContent();
        $data_decode = json_decode($data, true);
        $mari = $personneRepository->find($data_decode['Id_Mari']);
        $femme = $personneRepository->find($data_decode['Id_Femme']);
        $mariage
            ->setIdMari($mari)
            ->setIdMarie($femme)
            ->setDateMariage( new \DateTime($data_decode['Date_Mariage']));
        $em->persist($mariage);
        $em->flush();
        return $this->json(['message' => 'Mariage inserer'],200,[]);
    }

    #[Route('/api/Mariage',name:'Liste_Marier',methods:'GET')]
    public function liste(MariageRepository $mariageRepository,EnfantRepository $enfantRepository){
        $results = $mariageRepository->findMariagesWithChildrenCount();
        $data = [];
        $i = 0;

        foreach ($results as $result) {
        $id = $result['id'];
        $enfant = $result['children_count'];
        $mariage = $mariageRepository->find($id);

        $data[$i] = ['mariage' => $mariage, 'enfant' => $enfant];
        $i++;
    }
        return $this->json($data,200,[]);
    }
    #[Route('/api/Personne_parent', name: 'selectPersonne_parent', methods: ['GET'])]
        public function getCouple(MariageRepository $mariageRepository)
        {
            return $this->json($mariageRepository->getPersonne_parent() , 200, []);
        }
}
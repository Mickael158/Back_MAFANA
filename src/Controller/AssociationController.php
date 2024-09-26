<?php
    namespace App\Controller;

use App\Entity\Association;
use App\Repository\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


    class AssociationController extends AbstractController{
        #[Route('/api/Association/{id}',name:'modification_Association',methods:'POST')]
        public function modifier(Association $Association,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Association->setNom($data_decode['Nom']);
            $Association->setSiege($data_decode['Siege']);
            $Association->setNatureJuridique($data_decode['natureJuridique']);
            $Association->setSecteurActivite($data_decode['secteurActivite']);
            $Association->setTelephone($data_decode['Telephone']);
            $Association->setEmail($data_decode['Email']);
            $Association->setSlogan($data_decode['Slogan']);
            $Association->setLogo($data_decode['Logo']);
            $Association->setDescription($data_decode['Description']);
            $em->flush();
            return $this->json(['message' => 'Association modifier'], 200, []);
        }

        #[Route('/api/Association/message',name:'message_Association',methods:'POST')]
        public function message(Request $request,  AssociationRepository $AssociationRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Envoyeur = ($data_decode['Envoyeur']);
            $Destitateur = ($data_decode['Destitateur']);
            $Sujet = ($data_decode['Sujet']);
            $Message = ($data_decode['Message']);
            $AssociationRepository->envoyerEmail($Envoyeur,$Destitateur,$Sujet,$Message);
            return $this->json(['message' => 'ENvoyer'], 200, []);
        }

        #[Route('/api/Associations/{id}',name:'selectAlls_Association',methods:'GET')]
        public function selectAlls(int $id , AssociationRepository $AssociationRepository){
            return $this->json($AssociationRepository->find($id), 200, []);
        }
    }
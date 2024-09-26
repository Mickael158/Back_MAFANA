<?php
    namespace App\Controller;

use App\Entity\PersonneMembre;
use App\Entity\Decede;
use App\Entity\Profession;
use App\Repository\DecedeRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\ProfessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


    class DecedeController extends AbstractController{
        #[Route('/api/Decede',name:'insetion_Decede',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em , PersonneMembreRepository $personneMembreRepository){
            $Decede = new Decede();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $personne = $personneMembreRepository->find($data_decode['IdPersonneMembre']);
            $Decede->setIdPersonneMembre($personne);
            $Decede->setDateDece(new \DateTime($data_decode['date_dece']));
            $em->persist($Decede);
            $em->flush();
            return $this->json(['message' => 'Personne dece inserer'], 200, []);
        }
    }
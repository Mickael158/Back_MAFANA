<?php
    namespace App\Controller;

use App\Entity\RefuserDemandeMateriel;
use App\Repository\DemandeMaterielRepository;
use App\Repository\UsersRepository;
use App\Repository\RefuserDemandeMaterielRepository;
use App\Service\TresorerieService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class RefuserDemandeMaterielController extends AbstractController{

        #[Route('/api/RefuserDemandeMateriel',name:'insetion_RefuserDemandeMateriel',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em,DemandeMaterielRepository $demandeMaterielRepository,UsersRepository $usersRepository,TresorerieService $tresorerieService,JWTEncoderInterface $jWTEncoderInterface){
            $RefuserDemandeMateriel = new RefuserDemandeMateriel();
                $data = $request->getContent();
                $data_decode = json_decode($data, true);
                dd($data_decode);
                $demande = $demandeMaterielRepository->find($data_decode['id_demande_materiel_id']);
                $decode = $jWTEncoderInterface->decode($data_decode['utilisateur']);
                $utilisateur = $usersRepository->findOneBy(['username'=>$decode['username']]);
                $RefuserDemandeMateriel
                    ->setIdDemandeMateriel($demande)
                    ->setIdUtilisateur($utilisateur)
                    ->setDates(new \DateTime());
                $em->persist($RefuserDemandeMateriel);
                $em->flush();
            return $this->json(['message' => 'Refuser Demande Materiel inserer'], 200, []);
        }
    }
<?php
    namespace App\Controller;

use App\Entity\RefuserDemandeFinancier;
use App\Repository\DemandeFinancierRepository;
use App\Repository\UsersRepository;
use App\Repository\RefuserDemandeFinancierRepository;
use App\Service\TresorerieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class RefuserDemandeFinancierController extends AbstractController{

        #[Route('/api/RefuserDemandeFinancier',name:'insetion_RefuserDemandeFinancier',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em,DemandeFinancierRepository $demandeFinancierRepository,UsersRepository $usersRepository,TresorerieService $tresorerieService){
                $RefuserDemandeFinancier = new RefuserDemandeFinancier();
                $data = $request->getContent();
                $data_decode = json_decode($data, true);
                $demande = $demandeFinancierRepository->find($data_decode['id_demande_financier_id']);
                $utilisaTeur = $usersRepository->find($data_decode['utilisateur']);
                $RefuserDemandeFinancier
                    ->setIdDemandeFinancier($demande)
                    ->setIdUtilisateur($utilisaTeur)
                    ->setDates(new \DateTime());
                $em->persist($RefuserDemandeFinancier);
                $em->flush();
            return $this->json(['message' => 'Refuser Demande Financier inserer'], 200, []);
        }
    }
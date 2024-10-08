<?php
    namespace App\Controller;

use App\Entity\ValidationDemandeFinancier;
use App\Repository\DemandeFinancierRepository;
use App\Repository\UsersRepository;
use App\Repository\ValidationDemandeFinancierRepository;
use App\Service\TresorerieService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class ValidationFinancierController extends AbstractController{

        #[Route('/api/ValidationDemandeFinancier',name:'insetion_ValidationDemandeFinancier',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em,DemandeFinancierRepository $demandeFinancierRepository,UsersRepository $usersRepository,TresorerieService $tresorerieService,JWTEncoderInterface $jWTEncoderInterface){
            $em->beginTransaction();    
            try {
                $ValidationDemandeFinancier = new ValidationDemandeFinancier();
                $data = $request->getContent();
                $data_decode = json_decode($data, true);
                $demande = $demandeFinancierRepository->find($data_decode['id_demande_financier_id']);
                $decode = $jWTEncoderInterface->decode($data_decode['utilisateur']);
                $utilisateur = $usersRepository->findOneBy(['username'=>$decode['username']]);
                $ValidationDemandeFinancier
                    ->setMontant($data_decode['Montant'])
                    ->setIdDemandeFinancier($demande)
                    ->setIdUtilisateur($utilisateur)
                    ->setDateValidation(new \DateTime());
                $em->persist($ValidationDemandeFinancier);
                $em->flush();
                $tresorerieService->insertMoins($data_decode['Montant']);
                $em->commit();
                } catch (\Exception $th) {
                    $em->rollback();
                }
            return $this->json(['message' => 'Validation Demande Financier inserer'], 200, []);
        }
    }
<?php
    namespace App\Controller;

use App\Entity\ValidationDemandeMateriel;
use App\Repository\DemandeMaterielRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class ValidationMaterielController extends AbstractController{

        #[Route('/api/ValidationDemandeMateriel',name:'insetion_ValidationDemandeMateriel',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em,UsersRepository $usersRepository,DemandeMaterielRepository $demandeMaterielRepository){
            $em->beginTransaction();    
            try {
                $ValidationDemandeMateriel = new ValidationDemandeMateriel();
                $data = $request->getContent();
                $data_decode = json_decode($data, true);
                $demande = $demandeMaterielRepository->find($data_decode['id_demande_materiel_id']);
                $utilisaTeur = $usersRepository->find($data_decode['utilisateur']);
                $ValidationDemandeMateriel
                    ->setIdUtilisateur($utilisaTeur)
                    ->setNombre($data_decode['Nombre'])
                    ->setIdDemandeMateriel($demande)
                    ->setDateDeValidation(new \DateTime());
                $em->persist($ValidationDemandeMateriel);
                $em->flush();
                $em->commit();
                } catch (\Exception $th) {
                    $em->rollback();
                }
            return $this->json(['message' => 'Validation Demande Materiel inserer'], 200, []);
        }
    }
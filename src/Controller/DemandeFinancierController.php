<?php
    namespace App\Controller;

use App\Entity\DemandeFinancier;
use App\Repository\DemandeFinancierRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\UsersRepository;
use App\Service\TresorerieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_DEMANDE")'))]
    class DemandeFinancierController extends AbstractController{

        #[Route('/api/DemandeFinancier',name:'insetion_DemandeFinancier',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em ,PersonneMembreRepository $personneMembreRepository,TresorerieService $tresorerieService){
            $DemandeFinancier = new DemandeFinancier();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $personne = $personneMembreRepository->find($data_decode['id_personne_membre_id']);
            $DemandeFinancier->setIdPersonneMembre($personne);
            $DemandeFinancier->setDateDemandeFinancier(new \DateTime());
            $DemandeFinancier->setMontant($data_decode['montant']);
            $DemandeFinancier->setMotif($data_decode['motif']);
            $em->persist($DemandeFinancier);
            $em->flush();

            $tresorerieService->insert($DemandeFinancier->getMontant());
            return $this->json(['message' => 'DemandeFinancier inserer'], 200, []);
        }
        #[Route('api/rechercheDemandeFinancier', name:'RechercheDemandeFinancier', methods:'POST')]
        public function rechercheDemandeFinancier(Request $request, DemandeFinancierRepository $demandeFinancierRepository, PersonneMembreRepository $personneMembreRepository)
        {
            $data = $request->getContent();
            $data_decode = json_decode($data, true);

            $searchData = $data_decode['data'] ?? null; 
            $montant = $data_decode['montant'] ?? null; 
            $dateDebut = $data_decode['dateDebut'] ?? null;
            $dateFin = $data_decode['dateFin'] ?? null; 

            $results = $demandeFinancierRepository->rechercheDemandeFinancier($searchData, $montant, $dateDebut, $dateFin);
            
            if (!empty($results)) {
                return $this->json([
                    'success' => true,
                    'data' => $results,
                ]);
            } else {
                return $this->json([
                    'success' => false,
                    'message' => 'Aucun résultat trouvé pour les critères spécifiés.',
                ]);
            }
        }

    }
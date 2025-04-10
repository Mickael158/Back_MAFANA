<?php
    namespace App\Controller;

use App\Entity\DemandeMateriel;
use App\Entity\DonnationMateriel;
use App\Repository\DemandeFinancierRepository;
use App\Repository\DemandeMaterielRepository;
use App\Repository\DonnationMaterielRepository;
use App\Repository\MaterielRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\UsersRepository;
use App\Service\InvestigationFinancier;
use App\Service\StockService;
use App\Service\TresorerieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_DEMANDE")'))]
    class DemandeMaterielController extends AbstractController{

        #[Route('/api/DemandeMateriel',name:'insetion_DemandeMateriel',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em ,PersonneMembreRepository $personneMembreRepository,MaterielRepository $materielRepository,TresorerieService $tresorerieService){
            $DemandeMateriel = new DemandeMateriel();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $personne = $personneMembreRepository->find($data_decode['id_personne_membre_id']);
            $matereil = $materielRepository->find($data_decode['id_materiel_id']);
            $DemandeMateriel->setIdPersonneMembre($personne);
            $DemandeMateriel->setDateDeDemande(new \DateTime());
            $DemandeMateriel->setIdMateriel($matereil);
            $DemandeMateriel->setMotif($data_decode['motif']);
            $DemandeMateriel->setNombre($data_decode['nbr']);
            $em->persist($DemandeMateriel);
            $em->flush();
            return $this->json(['message' => 'Demande Materiel inserer'], 200, []);
        }
        

        #[Route('/api/stock/{id}',name:'stock',methods:'GET')]
        public function stock($id,MaterielRepository $materielRepository,DemandeMaterielRepository $demandeMaterielRepository){
            $stockMateriel = $demandeMaterielRepository->getStockMateriel($id);
            $Materiel = $materielRepository->find($id);
            $stockService = new StockService();
            $stockService
                ->setMateriel($Materiel)
                ->setNombre($stockMateriel[0]['difference']);
            
            return $this->json($stockService, 200, []);
        }
        #[Route('/api/rechercheDemandeMateriels', name:'RechercheMateriels', methods:'POST')]
        public function rechercheDemandeMateriels(Request $request, DemandeMaterielRepository $demandeMaterielRepository)
        {
            $data = $request->getContent();
            $data_decode = json_decode($data, true);

            $searchData = $data_decode['data'] ?? null;
            $materielId = $data_decode['materielId'] ?? null;
            $dateDebut = $data_decode['dateDebut'] ?? null;
            $dateFin = $data_decode['dateFin'] ?? null;
            
            $results = $demandeMaterielRepository->rechercheDemandeMateriel($searchData, $materielId, $dateDebut, $dateFin);
           
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
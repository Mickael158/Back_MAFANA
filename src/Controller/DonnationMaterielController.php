<?php
    namespace App\Controller;

use App\Entity\DonnationMateriel;
use App\Entity\Materiel;
use App\Repository\DemandeFinancierRepository;
use App\Repository\DemandeMaterielRepository;
use App\Repository\DonnationMaterielRepository;
use App\Repository\MaterielRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\UsersRepository;
use App\Service\AffichageDonationMateriel;
use App\Service\InvestigationMateriel;
use App\Service\TresorerieService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_PAYEMENT")'))]
    class DonnationMaterielController extends AbstractController{

        #[Route('/api/DonnationMateriels',name:'insetion_DonnationMateriel',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em , UsersRepository $usersRepository, MaterielRepository $materielrepository,TresorerieService $tresorerieService,JWTEncoderInterface $jWTEncoderInterface){
            $DonnationMateriel = new DonnationMateriel();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $decode = $jWTEncoderInterface->decode($data_decode['utilisateur']);
            $user = $usersRepository->findOneBy(['username'=>$decode['username']]);
            $materiel = $materielrepository->find($data_decode['id_materiel_id']);
            $DonnationMateriel->setNomDonnateurMateriel($data_decode['nom_donnateur_materiel']);
            $DonnationMateriel->setDateAcquisition(new \DateTime());
            $DonnationMateriel->setNombre($data_decode['nombre']);
            $DonnationMateriel->setImage($data_decode['image']);
            $DonnationMateriel->setIdMateriel($materiel);
            $DonnationMateriel->setIdUtilisateurId($user);
            $em->persist($DonnationMateriel);
            $em->flush();
            return $this->json(['message' => 'Donnation Materiel inserer'], 200, []);
        }
        #[Route('/api/selectDemandeMateriel',name:'select_DemandeMateriel',methods:'GET')]
        public function selectAll_DemandeFinacier(DemandeMaterielRepository $demandeMaterielRepository , InvestigationMateriel $investigationMateriel , PersonneMembreRepository $personneMembreRepository ,DemandeFinancierRepository $demandeFinancierRepository){
            $demande_initial = $demandeMaterielRepository->getDemanceMateriel_With_Investi();
            $demande_final = [];
            for($i = 0 ; $i<count($demande_initial) ; $i++){
                $investigationMateriel = new InvestigationMateriel();
                $pourcentage = $demandeMaterielRepository->pourcentage($demande_initial[$i]['id_personne_membre_id'] , $personneMembreRepository , $demandeFinancierRepository);
                $demande = $demandeMaterielRepository->find($demande_initial[$i]['id']);
                $personne = $personneMembreRepository->find($demande_initial[$i]['id_personne_membre_id']);
                $investigationMateriel->setPersonnMembre($personne);
                $investigationMateriel->setMotif($demande_initial[$i]['motif']);
                $investigationMateriel->setNombre($demande_initial[$i]['nombre']);
                $investigationMateriel->setPourcentage($pourcentage);
                $investigationMateriel->setDemandeMateriel($demande);
                $demande_final[] = $investigationMateriel;
            }
            return $this->json($demande_final, 200, []);
        }
        #[Route('/api/SelectAllDonnationMaterile',name:'SelectAllDonnationMaterile',methods:'GET')]
        public function selectAll(DonnationMaterielRepository $demandeFinancierRepository){
            return $this->json($demandeFinancierRepository->findAll(), 200, []);
        }
        #[Route('api/rechercheMateriel',name:'RechercheMateriel',methods:'POST')]
        public function rechercheDonnation(Request $request, DonnationMaterielRepository $donationMaterielRepository , PersonneMembreRepository $personneMembreRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
                
            $searchData = $data_decode['data'] ?? null; 
            $materiel = $data_decode['materiel'] ?? null; 
            $dateDebut = $data_decode['dateDebut'] ?? null;
            $dateFin = $data_decode['dateFin'] ?? null; 
            $results = $donationMaterielRepository->rechercheMateriel($searchData, $materiel,$dateDebut, $dateFin);
            for($i = 0 ; $i < count($results) ; $i++){
                $nom_prenom = explode(' ',$results[$i]['nom_donnateur_materiel']);
                $prenom = implode(' ', array_slice($nom_prenom, 1));
                $search_personne = $personneMembreRepository->getPersonneByNomPrenom($nom_prenom[0] , $prenom);
                $affichageDonationMateriel = new AffichageDonationMateriel();
                $affichageDonationMateriel->setNomDonnateurMateriel($results[$i]['nom_donnateur_materiel']);
                $affichageDonationMateriel->setDateAcquisition(new \DateTime($results[$i]['date_acquisition']));
                $affichageDonationMateriel->setNomMateriel($results[$i]['nom_materiel']);
                $affichageDonationMateriel->setNombre($results[$i]['nombre']);
                $affichageDonationMateriel->setStatus($search_personne ? true : false);
                $affichage[] = $affichageDonationMateriel;
            }
            if ($affichage) {
                return $this->json([
                    'success' => true,
                    'data' => $affichage,
                ]);
            } else {
                return $this->json([
                    'success' => false,
                    'message' => 'Aucun résultat trouvé pour les critères spécifiés.',
                ]);
            }
        }
    }
<?php
    namespace App\Controller;

use App\Entity\DonationFinancier;
use App\Entity\DonnationMateriel;
use App\Entity\PersonneMembre;
use App\Repository\DemandeFinancierRepository;
use App\Repository\DemandeMaterielRepository;
use App\Repository\DonationFinancierRepository;
use App\Repository\DonnationMaterielRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\UsersRepository;
use App\Service\AffichageDonationFinancier;
use App\Service\InvestigationFinancier;
use App\Service\TresorerieService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_PAYEMENT")'))]
    class DonationFinancierController extends AbstractController{

        #[Route('/api/DonationFinancier',name:'insetion_DonationFinancier',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em , UsersRepository $usersRepository,TresorerieService $tresorerieService,JWTEncoderInterface $jWTEncoderInterface){
            $em->beginTransaction();    
            try {
            $DonationFinancier = new DonationFinancier();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $decode = $jWTEncoderInterface->decode($data_decode['utilisateur']);
            $user = $usersRepository->findOneBy(['username'=>$decode['username']]);
            $DonationFinancier->setNomDonationFinancier($data_decode['nom_donation_financier']);
            $DonationFinancier->setDateDonationFinancier(new \DateTime());
            $DonationFinancier->setMontant($data_decode['montant']);
            $DonationFinancier->setIdUtilisateur($user);
            $em->persist($DonationFinancier);
            $em->flush();

            $tresorerieService->insert($DonationFinancier->getMontant());
            $em->commit();
                } catch (\Exception $th) {
                    $em->rollback();
                }
            return $this->json(['message' => 'Donation Financier inserer'], 200, []);
        }
        #[Route('/api/DemandeFinaciers',name:'insetion_DemandeFinaciers',methods:'GET')]
        public function selectAlls_DemandeFinacier(DemandeFinancierRepository $demandeFinancierRepository , InvestigationFinancier $investigationFinancier , PersonneMembreRepository $personneMembreRepository){
            $demande_initial = $demandeFinancierRepository->getDemanceFinancier_With_Investi();
            $demande_final = [];
            for($i = 0 ; $i<count($demande_initial) ; $i++){
                $investigationFinancier = new InvestigationFinancier();
                $pourcentage = $demandeFinancierRepository->pourcentage($demande_initial[$i]['id_personne_membre_id']);
                $demande = $demandeFinancierRepository->find($demande_initial[$i]['id']);
                $personne = $personneMembreRepository->find($demande_initial[$i]['id_personne_membre_id']);
                $investigationFinancier->setPersonnMembre($personne);
                $investigationFinancier->setMotif($demande_initial[$i]['motif']);
                $investigationFinancier->setMontant($demande_initial[$i]['montant']);
                $investigationFinancier->setPourcentage($pourcentage);
                $investigationFinancier->setDemandefinancier($demande);
                $demande_final[] = $investigationFinancier;
            }
            return $this->json($demande_final, 200, []);
        }
        #[Route('/api/SelectAllDonnationFinancier',name:'SelectAllDonnationFinancier',methods:'GET')]
        public function selectAll(DonationFinancierRepository $donationFinancierRepository){
            return $this->json($donationFinancierRepository->findAll(), 200, []);
        }

        #[Route('api/rechercheDonnation',name:'RechercheDon',methods:'POST')]
        public function rechercheDonnation(Request $request, DonationFinancierRepository $donationFinancierRepository , PersonneMembreRepository $personneMembreRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $affichage = [];
            $searchData = $data_decode['data'] ?? null; 
            $dateDebut = $data_decode['dateDebut'] ?? null;
            $dateFin = $data_decode['dateFin'] ?? null; 
            $results = $donationFinancierRepository->rechercheDonation($searchData, $dateDebut, $dateFin);
            for($i = 0 ; $i < count($results) ; $i++){
                $nom_prenom = explode(' ',$results[$i]['nom_donation_financier']);
                $prenom = implode(' ', array_slice($nom_prenom, 1));
                $search_personne = $personneMembreRepository->getPersonneByNomPrenom($nom_prenom[0] , $prenom);
                $affichageDonationFinancier = new AffichageDonationFinancier();
                $affichageDonationFinancier->setNomDonationFinancier($results[$i]['nom_donation_financier']);
                $affichageDonationFinancier->setDateDonationFinancier(new \DateTime($results[$i]['date_donation_financier']));
                $affichageDonationFinancier->setMontant($results[$i]['montant']);
                $affichageDonationFinancier->setStatus($search_personne ? true : false);
                $affichage[] = $affichageDonationFinancier;
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
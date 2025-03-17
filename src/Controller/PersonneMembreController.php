<?php
    namespace App\Controller;

use App\Entity\DemandeFinancier;
use App\Entity\Enfant;
use App\Entity\Mariage;
use App\Entity\PersonneMembre;
use App\Entity\RestaurationMembre;
use App\Entity\Telephone;
use App\Entity\Users;
use App\Repository\DemandeFinancierRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\VillageRepository;
use App\Repository\GenreRepository;
use App\Service\InvestigationFinancier;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

    #[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_MEMBRE") or is_granted("ROLE_PAYEMENT")'))]
    class PersonneMembreController extends AbstractController{

        #[Route('/api/Personne',name:'insetion_Personne',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em,VillageRepository $villageRepository, GenreRepository $genreRepository,PersonneMembreRepository $personneMembreRepository, UserPasswordHasherInterface $hasher){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $result = $personneMembreRepository->getPersonneByNomPrenoms($data_decode['personne']['Nom'],$data_decode['personne']['Prenom']);
            $resultEmail = $personneMembreRepository->getPersonneByEmail( $data_decode['personne']['Email']);
            if($result){
                return $this->json(['error'=>'Cette personne est dejas ennregistrer!'],200,[]);
            }
            else if($resultEmail){
                return $this->json(['error'=>'Cette email est dejas ennregistrer!'],200,[]);
            }else{
                $Personne = new PersonneMembre();
                $village = $villageRepository->find($data_decode['personne']['IdVillage']);
                $genre = $genreRepository->find($data_decode['personne']['IdGenre']);
                $Personne
                    ->setNomMembre($data_decode['personne']['Nom'])
                    ->setDateDeNaissance(new \DateTime($data_decode['personne']['DateNaissance']))
                    ->setAddress($data_decode['personne']['Adresse'])
                    ->setAddressTana($data_decode['personne']['AdressTana'])
                    ->setFokotany($data_decode['personne']['Fokotany'])
                    ->setArrondissement($data_decode['personne']['Arrondissement'])
                    ->setCIN($data_decode['personne']['CIN'])
                    ->setEmail($data_decode['personne']['Email'])
                    ->setPrenomMembre($data_decode['personne']['Prenom'])
                    ->setDateInscription(new \DateTime($data_decode['personne']['DateInscription']))
                    ->setIdVillage($village)
                    ->setIdGenre($genre);
                $em->persist($Personne);
                $em->flush();
                
                $user = new Users();
                $user
                    ->setUsername($Personne->getEmail())
                    ->setPassword($hasher->hashPassword($user,'000000'))
                    ->setIdPersonne($Personne)
                    ->setRoles(['ROLE_USER'])
                    ;
                $em->persist($user);
                $em->flush();

                $telephone = $data_decode['telephone'];

                foreach ($telephone as $value) {
                    $newTelephone = new Telephone();
                    $newTelephone
                        ->setIdPersonneMembre($Personne)
                        ->setTelephone($value);
                        $em->persist($newTelephone);
                        $em->flush();
                }

            }

            $resultFemme = $personneMembreRepository->getPersonneByNomPrenoms($data_decode['femme']['Nom'],$data_decode['femme']['Prenom']);
            $resultEmailFemme = $personneMembreRepository->getPersonneByEmail( $data_decode['femme']['Email']);
            if($resultFemme){
                return $this->json(['error'=>'Cette personne est dejas ennregistrer!'],200,[]);
            }
            else if($resultEmailFemme){
                return $this->json(['error'=>'Cette email est dejas ennregistrer!'],200,[]);
            }else{
                $PersonneFemme = new PersonneMembre();
                $village = $villageRepository->find($data_decode['personne']['IdVillage']);
                $genre = $genreRepository->find($data_decode['personne']['IdGenre']);
                $PersonneFemme
                    ->setNomMembre($data_decode['femme']['Nom'])
                    ->setDateDeNaissance(new \DateTime($data_decode['femme']['DateNaissance']))
                    ->setAddress($data_decode['femme']['Adresse'])
                    ->setAddressTana($data_decode['femme']['AdressTana'])
                    ->setFokotany($data_decode['femme']['Fokotany'])
                    ->setArrondissement($data_decode['femme']['Arrondissement'])
                    ->setCIN($data_decode['femme']['CIN'])
                    ->setEmail($data_decode['femme']['Email'])
                    ->setPrenomMembre($data_decode['femme']['Prenom'])
                    ->setDateInscription(new \DateTime($data_decode['femme']['DateInscription']))
                    ->setIdVillage($village)
                    ->setIdGenre($genre);
                $em->persist($PersonneFemme);
                $em->flush();

                $telephonefemme = $data_decode['telephonesFemme'];

                foreach ($telephonefemme as $value) {
                    $newTelephoneFemme = new Telephone();
                    $newTelephoneFemme
                        ->setIdPersonneMembre($PersonneFemme)
                        ->setTelephone($value);
                        $em->persist($newTelephoneFemme);
                        $em->flush();
                }
            }

            $mariage = new Mariage();
            $mariage 
                ->setDateMariage(new \DateTime())
                ->setIdMari($Personne)
                ->setIdMarie($PersonneFemme);

            $em->persist($mariage);
            $em->flush();
            

            $enfant = $data_decode['enfant'];

            foreach ($enfant as $value) {
                $personneEnfant = new PersonneMembre();
                $village = $villageRepository->find($value['IdVillage']);
                $genre = $genreRepository->find($value['IdGenre']);
                $personneEnfant
                    ->setNomMembre($value['Nom'])
                    ->setDateDeNaissance(new \DateTime($value['DateNaissance']))
                    ->setAddress($value['Adresse'])
                    ->setAddressTana($value['AdressTana'])
                    ->setFokotany($value['Fokotany'])
                    ->setArrondissement($value['Arrondissement'])
                    ->setCIN($value['CIN'])
                    ->setEmail($value['Email'])
                    ->setPrenomMembre($value['Prenom'])
                    ->setDateInscription(new \DateTime($value['DateInscription']))
                    ->setIdVillage($village)
                    ->setIdGenre($genre);
                $em->persist($personneEnfant);
                $em->flush();

                $telephoneEnfant = $data_decode['telephonesFemme'];

                foreach ($telephoneEnfant as $value) {
                    $newTelephoneEnfant = new Telephone();
                    $newTelephoneEnfant
                        ->setIdPersonneMembre($personneEnfant)
                        ->setTelephone($value);
                        $em->persist($newTelephoneEnfant);
                        $em->flush();
                }

                $enfantPersonne = new Enfant();
                $enfantPersonne
                    ->setIdEnfant($personneEnfant)
                    ->setIdMariageParent($mariage);
                    $em->persist($enfantPersonne);
                    $em->flush();
            }
            return $this->json(['message' => 'personne inserer'],200,[]);
        }

        #[Route('/api/PersonneTest',name:'Test_Personne',methods:'POST')]
        public function Test(Request $request,PersonneMembreRepository $personneMembreRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $result = $personneMembreRepository->getPersonneByNomAndPrenom($data_decode['nom'],$data_decode['prenom']);
            return $this->json($result,200,[]);
        }



        #[Route('/api/Personne/{id}',name:'modification_Personne',methods:'POST')]
        public function modifier(PersonneMembre $Personne,Request $request, EntityManagerInterface $em,VillageRepository $villageRepository, GenreRepository $genreRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $village = $villageRepository->find($data_decode['IdVillage']);
            $genre = $genreRepository->find($data_decode['IdGenre']);
            $Personne
                ->setNomMembre($data_decode['Nom'])
                ->setDateDeNaissance(new \DateTime($data_decode['DateNaissance']))
                ->setAddress($data_decode['Adresse'])
                ->setEmail($data_decode['Email'])
                ->setPrenomMembre($data_decode['Prenom'])
                ->setIdVillage($village)
                ->setIdGenre($genre);
            $em->persist($Personne);
            $em->flush();
            return $this->json(['message' => 'Personne modifier'], 200, []);
        }

        #[Route('/api/Personne/supprimer/{id}',name:'suppresseion_Personne',methods:'POST')]
        public function supprimer(PersonneMembre $Personne,Request $request, EntityManagerInterface $em){
            $em->remove($Personne);
            $em->flush();
            return $this->json(['message' => 'Personne Supprimer'], 200, []);
        }

        #[Route('/api/Personne',name:'selectAll_Personne',methods:'GET')]
        public function selectAll(PersonneMembreRepository $PersonneMembreRepository){
            return $this->json($PersonneMembreRepository->findAll(), 200, []);
        }

        

        #[Route('/api/Personne/{id}',name:'selectId_Personne',methods:'GET')]
        public function selectById($id,PersonneMembreRepository $PersonneMembreRepository){
            return $this->json($PersonneMembreRepository->find($id), 200, []);
        }
        #[Route('/api/PersonneGenre/{genre}',name:'select_Personne_bye_genre',methods:'GET')]
        public function selectByGenre($genre,PersonneMembreRepository $PersonneMembreRepository,GenreRepository $genreRepository){
            $genrePersonne = $genreRepository->findBy(['Nom_Genre'=>$genre]);
            return $this->json($PersonneMembreRepository->findBy(['Id_Genre'=>$genrePersonne[0]]), 200, []);
        }

        #[Route('/api/PersonneCharge_ByResposanble/{id}',name:'PersonneCharge_ByResposanble',methods:'GET')]
        public function PersonneCharge_ByResposanble($id , PersonneMembreRepository $PersonneMembreRepository){

            return $this->json($PersonneMembreRepository->PersonneCharge_ByResposanble($id), 200, []);
        }
        #[Route('/api/PersonneEnfant',name:'select_Personne_non_marie',methods:'GET')]
        public function MembreEnfant(PersonneMembreRepository $PersonneMembreRepository){

            return $this->json($PersonneMembreRepository->findPersonnesNonMariees(), 200, []);
        }
        #[Route('/api/PersonneIndep', name: 'selectId_Personne_indep', methods: ['GET'])]
        public function Personne_independant(PersonneMembreRepository $personneMembreRepository)
        {
            return $this->json($personneMembreRepository->getPersIndep() , 200, []);
        }
        #[Route('api/recherchePersonneIndep',name:'RecherchePersonneIndep',methods:'POST')]
        public function RecherchePersonneIndep(Request $request, PersonneMembreRepository $personneMembreRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
                
            $searchData = $data_decode['data'] ?? null; 
            $village = $data_decode['village'] ?? null; 
            $results = $personneMembreRepository->getPersIndepRecherche($searchData, $village);
            if ($results) {
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

        #[Route('api/recherchePersonne',name:'RecherchePersonne',methods:'POST')]
        public function RecherchePersonne(Request $request, PersonneMembreRepository $personneMembreRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
                
            $searchData = $data_decode['data'] ?? null; 
            $village = $data_decode['village'] ?? null; 
            $genre = $data_decode['genre'] ?? null; 
            $profession = $data_decode['profession'] ?? null; 
            $results = $personneMembreRepository->recherchePersonneAll($searchData, $village, $genre, $profession);
            if ($results) {
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

        #[Route('/api/Personne/update/{id}',name:'Update_personne',methods:'POST')]
        public function Update(PersonneMembre $personneMembre,EntityManagerInterface $em,Request $request,GenreRepository $genreRepository,VillageRepository $villageRepository){
        $data = $request->getContent();
        $data_decode = json_decode($data,true);
        $genre = $genreRepository->find($data_decode['genre_id']);
        $village = $villageRepository->find($data_decode['village_id']);
        $personneMembre
                ->setNomMembre($data_decode['Nom'])
                ->setDateDeNaissance(new \DateTime($data_decode['DateNaissance']))
                ->setAddress($data_decode['Adresse'])
                ->setEmail($data_decode['Email'])
                ->setPrenomMembre($data_decode['Prenom'])
                ->setDateInscription(new \DateTime())
                ->setIdVillage($village)
                ->setIdGenre($genre);
        $em->flush();
        return $this->json(['message'=>'Information du personne modifié'], 200, []);
        }

        #[Route('/api/PersonneAllById/{id}', name: 'PersonneAllByd', methods: ['GET'])]
        public function PersonneAllById(PersonneMembre $personneMembre)
        {
            return $this->json($personneMembre , 200, []);
        }

        #[Route('/api/getPersIndepNotUser', name: 'selectId_Personne_indep_not_user', methods: ['GET'])]
        public function Personne_independant_not_user(PersonneMembreRepository $personneMembreRepository)
        {
            return $this->json($personneMembreRepository->getPersIndepNotUser() , 200, []);
        }
        #[Route('/api/getAnneInscription/{id}', name: 'getAnneInscription', methods: ['GET'])]
        public function getAnneInscription($id , PersonneMembreRepository $personneMembreRepository)
        {
            $now = (new \DateTime())->format('Y');;
            $nowInt = $now + 0;
            $inscription = $personneMembreRepository->getAnneInscription($id);
            $inscriptionInt = $inscription['annee_de_naissance']+0;
            $AllDates = [] ;
            $AllDates[] = $inscriptionInt;
            while($inscriptionInt < $nowInt) {
                $inscriptionInt = $inscriptionInt + 1;
                $AllDates[] = $inscriptionInt;
            }
            return $this->json($AllDates , 200, []);
        }
        #[Route('/api/getPersNotQuitte', name: 'selectId_Personne_not_quitte', methods: ['GET'])]
        public function Personne_independant_not_quitte(PersonneMembreRepository $personneMembreRepository)
        {
            return $this->json($personneMembreRepository->getPersNotQuitte() , 200, []);
        }
        #[Route('/api/Etat',name:'insetion_DemandeFinacier',methods:'POST')]
        public function selectAll_DemandeFinacier(Request $request,DemandeFinancierRepository $demandeFinancierRepository, InvestigationFinancier $investigationFinancier , PersonneMembreRepository $personneMembreRepository){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
                
            $searchData = $data_decode['data'] ?? null; 
            $village = $data_decode['village'] ?? null; 
            $personneAll = $personneMembreRepository->getPersIndepRecherche($searchData  , $village);
            $personnefin = [];
            for($i = 0 ; $i<count($personneAll) ; $i++){
                $investigationFinancier = new InvestigationFinancier();

                $pourcentage = $this->pourcentageAA($personneAll[$i]['id'] , $personneMembreRepository ,  $demandeFinancierRepository);
                $personne = $personneMembreRepository->find($personneAll[$i]['id']);
                $investigationFinancier->setPersonnMembre($personne);
                $investigationFinancier->setPourcentage($pourcentage);
                $personnefin[] = $investigationFinancier;
            }
            return $this->json($personnefin, 200, []);
        }
        public function pourcentageAA($id , PersonneMembreRepository $personneMembreRepository,DemandeFinancierRepository $demandeFinancierRepository) {
            $personneMembre = $personneMembreRepository->getPersonne_LastCotisation($id);
            $mois_total = $demandeFinancierRepository->differenceEnMois($personneMembre['date_inscription'] , new \DateTime());
            $mois_a_payer = $demandeFinancierRepository->differenceEnMois($personneMembre['dernier_payement'] , new \DateTime());
            if($mois_total == 0){
                return 0;
            }
            $diff =  $mois_total - $mois_a_payer ;
            $resultat =($diff * 100) / $mois_total;
            if($resultat > 100){
                $resultat = 100;
            }
            return $resultat;
        }

        #[Route('/api/personneQuitter',name:'personneAll_quitter',methods:'GET')]
        public function getPersonneQuitter(PersonneMembreRepository $personneMembreRepository){
            return $this->json(['reponse'=>$personneMembreRepository->getPersonneQuitter()],200,[]);
        }

        #[Route('/api/personneRestaurer/{id}',name:'personne_restaurer',methods:'POST')]
        public function PersonneRestorer(PersonneMembre $personneMembre,EntityManagerInterface $em){
            $restaurer = new RestaurationMembre();
            $restaurer
                ->setDateRestauration(new \DateTime())
                ->setIdPersonneMembre($personneMembre);
            $em->persist($restaurer);
            $em->flush();
            return $this->json(['message'=>'Membre restaurer'],200,[]);
        }


    }

    
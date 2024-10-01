<?php
    namespace App\Controller;

use App\Entity\DemandeFinancier;
use App\Entity\PersonneMembre;
use App\Repository\DemandeFinancierRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\VillageRepository;
use App\Repository\GenreRepository;
use App\Service\InvestigationFinancier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

    class PersonneMembreController extends AbstractController{

        #[Route('/api/Personne',name:'insetion_Personne',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em,VillageRepository $villageRepository, GenreRepository $genreRepository){
            $Personne = new PersonneMembre();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $village = $villageRepository->find($data_decode['IdVillage']);
            $genre = $genreRepository->find($data_decode['IdGenre']);
            $Personne
                ->setNomMembre($data_decode['Nom'])
                ->setDateDeNaissance(new \DateTime($data_decode['DateNaissance']))
                ->setAddress($data_decode['Adresse'])
                ->setEmail($data_decode['Email'])
                ->setTelephone($data_decode['Telephone'])
                ->setPrenomMembre($data_decode['Prenom'])
                ->setDateInscription(new \DateTime())
                ->setIdVillage($village)
                ->setIdGenre($genre);
            $em->persist($Personne);
            $em->flush();
            return $this->json(['message' => 'Personne inserer'], 200, []);
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
                ->setTelephone($data_decode['Telephone'])
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

        #[Route('/api/PersonneEnfant',name:'select_Personne_non_marie',methods:'GET')]
        public function MembreEnfant(PersonneMembreRepository $PersonneMembreRepository){

            return $this->json($PersonneMembreRepository->findPersonnesNonMariees(), 200, []);
        }
        #[Route('/api/PersonneIndep', name: 'selectId_Personne_indep', methods: ['GET'])]
        public function Personne_independant(PersonneMembreRepository $personneMembreRepository)
        {
            return $this->json($personneMembreRepository->getPersIndep() , 200, []);
        }
        #[Route('/api/getPersIndepNotUser', name: 'selectId_Personne_indep_not_user', methods: ['GET'])]
        public function Personne_independant_not_user(PersonneMembreRepository $personneMembreRepository)
        {
            return $this->json($personneMembreRepository->getPersIndepNotUser() , 200, []);
        }
        #[Route('/api/getPersNotQuitte', name: 'selectId_Personne_not_quitte', methods: ['GET'])]
        public function Personne_independant_not_quitte(PersonneMembreRepository $personneMembreRepository)
        {
            return $this->json($personneMembreRepository->getPersNotQuitte() , 200, []);
        }
        #[Route('/api/Etats',name:'insetion_DemandeFinacier',methods:'GET')]
        public function selectAll_DemandeFinacier(DemandeFinancierRepository $demandeFinancierRepository, InvestigationFinancier $investigationFinancier , PersonneMembreRepository $personneMembreRepository){
            $personneAll = $personneMembreRepository->findAll();
            $personnefin = [];
            for($i = 0 ; $i<count($personneAll) ; $i++){
                $investigationFinancier = new InvestigationFinancier();
                $pourcentage = $this->pourcentageAA(2, $personneMembreRepository, $demandeFinancierRepository);
                dd($pourcentage);
                $personne = $personneMembreRepository->find($personneAll[$i]->getId());
                $investigationFinancier->setPersonnMembre($personne);
                $investigationFinancier->setPourcentage($pourcentage);
                $personnefin[] = $investigationFinancier;
            }
            return $this->json($personnefin, 200, []);
        }
        #[Route('/api/pourcentage',name:'pourcentage',methods:'GET')]
        public function pourcentage(DemandeFinancierRepository $demandeFinancierRepository, InvestigationFinancier $investigationFinancier , DemandeFinancierRepository $de , PersonneMembreRepository $personneMembreRepository){
            $personneMembre = $personneMembreRepository->getPersonne_LastCotisation(2);
            $diff100 = $de->differenceEnMois($personneMembre['date_inscription'] , new \DateTime());
            $diffpayer = $de->differenceEnMois($personneMembre['dernier_payement'] , new \DateTime());
            if( $diffpayer < 0){
                $diffpayer =  1;
            }
            if($diff100 == 0){
                $diff100 = 1;
            }
            $pourcentage = ($diffpayer * 100) / $diff100;
            if($diff100 == $diffpayer){
                $pourcentage = 0;
            }
            
            return $this->json($pourcentage, 200, []);
        }

        public function pourcentageAA(
            $id, 
            PersonneMembreRepository $personneMembreRepository,
            DemandeFinancierRepository $demandeFinancierRepository
            ) {
            $personneMembre = $personneMembreRepository->getPersonne_LastCotisation($id);
            $mois_total = $demandeFinancierRepository->differenceEnMois($personneMembre['date_inscription'] , new \DateTime());
            $mois_a_payer = $demandeFinancierRepository->differenceEnMois($personneMembre['dernier_payement'] , new \DateTime());
            if($personneMembre['date_inscription'] == $personneMembre['dernier_payement']) {
                $mois_a_payer = 0;
            }

            return ($mois_a_payer * 100) / $mois_total;
        }
    }

    
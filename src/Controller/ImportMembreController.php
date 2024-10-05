<?php
    namespace App\Controller;

use App\Entity\ImportMembre;
use App\Entity\PersonneMembre;
use App\Entity\Vallee;
use App\Entity\Village;
use App\Repository\GenreRepository;
use App\Repository\ImportMembreRepository;
use App\Repository\ValleeRepository;
use App\Repository\VillageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

    class ImportMembreController extends AbstractController{

        #[Route('/api/import',name:'selectAll_Categorie',methods:'GET')]
        public function selectAll_import(ImportMembreRepository $ImportMembreRepository , EntityManagerInterface $em , ValleeRepository $valleeRepository , VillageRepository $villageRepository , GenreRepository $genreRepository){
            $file = "D:/Mafana/API/CSV/Classeur1.csv";
            $import = $ImportMembreRepository->findAllFromFile($file);
            foreach($import as $data_import){
                //$em->persist($data_import);
                //$em->flush();
            }
            $trangobeImport = $ImportMembreRepository->getImportDistinctTrangobe();
            foreach($trangobeImport as $trangobe){
                $valle = new Vallee();
                $valle->setNomVallee($trangobe['trangobe']);
                //$em->persist($valle);
                //$em->flush();
            }
            $fiaviana_antanana = $ImportMembreRepository->getImportDistinctfiaviana_antanana();
            foreach($fiaviana_antanana as $fiaviana){
                $valle = $valleeRepository->getValle_by_nomValle($fiaviana['trangobe']);
                $village = new Village();
                $village->setNomVillage($fiaviana['fiaviana_antanana']);
                $village->setIdVallee($valleeRepository->find($valle[0]['id']));
                $em->persist($village);
                //$em->flush();
            }
            $Allimportation = $ImportMembreRepository->findAll();
            foreach($Allimportation as $allImport){
                $personne = new PersonneMembre();
                $personne->setNomMembre($allImport->getAnarana());
                dd($allImport->getAnarana());
                $personne->setPrenomMembre($allImport->getPrenomMembre());
                $personne->setDateDeNaissance(new \DateTime($allImport['Daty_Naterahana']));
                $personne->setAddress($allImport['Adiresy_eto_Antananarivo']);
                $personne->setEmail($allImport['mailaka']);
                $personne->setTelephone($allImport['LaharanaFinday']);
                $personne->setIdVillage($villageRepository->find($allImport['fiaviana_antanana']));
                
                $personne->setIdGenre($genreRepository->find($genreRepository->getGenre_by_non($allImport['Lahy_na_Vavy'])));
            }
            return $this->json(['message' => 'Import etape 1'], 200, []);
        }


        // #[Route('/api/Categorie',name:'insetion_Categorie',methods:'POST')]
        // public function inerer(Request $request, EntityManagerInterface $em){
        //     $Categorie = new ImportMembre();
        //     $data = $request->getContent();
        //     $data_decode = json_decode($data, true);
        //     $Categorie->setNomCategorie($data_decode['Nom_Categorie']);
        //     $em->persist($Categorie);
        //     $em->flush();
        //     return $this->json(['message' => 'Categorie inserer'], 200, []);
        // }

        // #[Route('/api/Categorie/{id}',name:'modification_Categorie',methods:'POST')]
        // public function modifier(ImportMembre $Categorie,Request $request, EntityManagerInterface $em){
        //     $data = $request->getContent();
        //     $data_decode = json_decode($data, true);
        //     $Categorie->setNomCategorie($data_decode['Nom_Categorie']);
        //     $em->flush();
        //     return $this->json(['message' => 'Categorie modifier'], 200, []);
        // }

        // #[Route('/api/Categorie/supprimer/{id}',name:'suppresseion_Categorie',methods:'DELETE')]
        // public function supprimer(ImportMembre $Categorie,Request $request, EntityManagerInterface $em){
        //     $em->remove($Categorie);
        //     $em->flush();
        //     return $this->json(['message' => 'Categorie Supprimer'], 200, []);
        // }

        // #[Route('/api/Categorie',name:'selectAll_Categorie',methods:'GET')]
        // public function selectAll(ImportMembreRepository $ImportMembreRepository){
        //     return $this->json($ImportMembreRepository->findAll(), 200, []);
        // }

        // #[Route('/api/Categorie/{id}',name:'selectId_Categorie',methods:'GET')]
        // public function selectById($id,ImportMembreRepository $ImportMembreRepository){
        //     return $this->json($ImportMembreRepository->find($id), 200, []);
        // }
    }
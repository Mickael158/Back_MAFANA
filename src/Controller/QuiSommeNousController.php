<?php

namespace App\Controller;

use App\Entity\QuiSommeNous;
use App\Repository\PersonneMembreRepository;
use App\Repository\ProfessionRepository;
use App\Repository\QuiSommeNousRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class QuiSommeNousController extends AbstractController
{
    #[Route('/api/Qui',name:'Insertion_Qui',methods:'POST')]
    public function insertion(Request $request,EntityManagerInterface $em,PersonneMembreRepository $personneMembreRepository,ProfessionRepository $professionRepository)
    {
        $data = $request->getContent();
        $data_decode = json_decode($data, true);
        $personne = $personneMembreRepository->find($data_decode['personne_id']);
        $profession = $professionRepository->find($data_decode['profession_id']);
        $Qui = new QuiSommeNous();
        $Qui
            ->setPersonneId($personne)
            ->setProfessionId($profession)
            ->setImage('Image')
            ->setDateDebutMondat(new \DateTime($data_decode['DateDebut']))
            ->setDateFinMondat((new \DateTime($data_decode['DateDebut']))->modify('+'.$data_decode['mondat'].' years'));

        $em->persist($Qui);
        $em->flush();
        return $this->json(['message'=>'insertion reussit'],200,[]);
    }

    #[Route('/api/upload',name:'upload',methods:'POST')]
    public function upload(QuiSommeNousRepository $quiSommeNousRepository,Request $request,EntityManagerInterface $em,SluggerInterface $slugger)
    {
        $image = $request->files->get('image');
        $valeur = $quiSommeNousRepository->getLast();
        foreach ($valeur as $value){
            $QuiLastId = $value['id'];
        }
        $Qui = $quiSommeNousRepository->find($QuiLastId);
        if ($image) {
        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
            try {
                $image->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $Qui->setImage($newFilename);
            } catch (FileException $e) {
                return $this->json(['error' => 'Erreur lors de l\'upload de l\'image'], 500);
            }
        }
        $em->flush();
        return $this->json(['message'=>'upload reussit'],200,[]);
    }

    #[Route('/api/last',name:'last',methods:'GET')]
    public function getLast(QuiSommeNousRepository $quiSommeNousRepository){
        $valeur = $quiSommeNousRepository->getLast();
        foreach ($valeur as $value){
            $QuiLastId = $value['id'];
        }
        $Qui = $quiSommeNousRepository->find($QuiLastId);
        return $this->json(['message' => $Qui],200,[]);
    }
}
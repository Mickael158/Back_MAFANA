<?php
namespace App\Controller;

use App\Entity\OffreEmplois;
use App\Repository\OffreEmploisRepository;
use App\Repository\ProfessionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[IsGranted('ROLE_USER')]
#[Route("/api/offre", name:'api_offre')]
class OffreEmploisController extends AbstractController
{
    #[Route('',name:'',methods:'POST')]
    public function offre(Request $request,ProfessionRepository $professionRepository, EntityManagerInterface $em){
        $data = $request->getContent();
        $data_decode = json_decode($data,true);
        $user = $this->getUser();

        $idProfession = $data_decode['profession'];
        $date = $data_decode['date'];
        $description = $data_decode['description'];
        $titre = $data_decode['titre'];

        if($idProfession != '' && $date != '' && $description != ''){
            $profession =  $professionRepository->find($idProfession);
            $OffreEmplois = new OffreEmplois();
            $OffreEmplois
                ->setDescription($description)
                ->setDateOffre(new DateTime($date))
                ->setProfession($profession)
                ->setTitre($titre)
                ->setPersonneMembre($user->getIdPersonne());

            $em->persist($OffreEmplois);
            $em->flush();
            return $this->json(['success'=>'Offre envoyer!'],200,[]);
        }else{
            return $this->json(['error'=>'Veuillez remplir tous les champs!'],200,[]);
        }
    }

    #[Route('',name:'_find',methods:'GET')]
    public function getOffre(OffreEmploisRepository $offreEmploisRepository)
    {
        $offres = $offreEmploisRepository->findOffre();
        return $this->json($offres, 200 , []);
    }

    #[Route('/search',name:'_search',methods:'POST')]
    public function search(Request $request,OffreEmploisRepository $offreEmploisRepository,ProfessionRepository $professionRepository)
    {
        $data = $request->getContent();
        $data_decode = json_decode($data, true);
        $offres = $offreEmploisRepository->findByTitreOrProfession($data_decode['data'],$data_decode['profession']);
        return $this->json($offres,200, []);
    }
}
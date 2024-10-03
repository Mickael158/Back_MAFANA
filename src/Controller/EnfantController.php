<?php
namespace App\Controller;

use App\Entity\Enfant;
use App\Repository\EnfantRepository;
use App\Repository\MariageRepository;
use App\Repository\PersonneMembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_MEMBRE")'))]
class EnfantController extends AbstractController{

    // #[Route('/api/InsertionEnfant',name:'Nouveau_Enfant',methods:'POST')]
    // public function inserer(Request $request,EntityManagerInterface $em,MariageRepository $mariageRepository,PersonneMembreRepository $personneRepository){
        
    // }

    #[Route('/api/Enfant',name:'Liste_Enfant',methods:'post')]
    public function liste(Request $request,EntityManagerInterface $em,MariageRepository $mariageRepository,PersonneMembreRepository $personneRepository){
        $Enfant = new Enfant();
        $data = $request->getContent();
        $data_decode = json_decode($data, true);
        $mariage = $mariageRepository->find($data_decode['id_pere']);
        $enfant = $personneRepository->find($data_decode['id_enfant']);
        $Enfant
            ->setIdEnfant($enfant)
            ->setIdMariageParent($mariage);
        $em->persist($Enfant);
        $em->flush();
        return $this->json($Enfant,200,[]);
    }
}
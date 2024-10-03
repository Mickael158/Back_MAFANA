<?php
    namespace App\Controller;

use App\Entity\PersonneMembre;
use App\Entity\Quitte;
use App\Entity\Profession;
use App\Repository\QuitteRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\ProfessionRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_MEMBRE")'))]
    class QuitteController extends AbstractController{
        #[Route('/api/Quitte',name:'insetion_Quitte',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em , PersonneMembreRepository $personneMembreRepository ){
            $Quitte = new Quitte();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $personne = $personneMembreRepository->find($data_decode['IdPersonneMembre']);
            $Quitte->setIdPersonneMembre($personne);
            $Quitte->setDate(new \DateTime($data_decode['date']));
            $em->persist($Quitte);
            $em->flush();
            return $this->json(['message' => 'Personne Membre Profession inserer'], 200, []);
        }
        #[Route('/api/Quitte/{id}',name:'selectAll_Association',methods:'GET')]
        public function selectAll(int $id ,QuitteRepository $QuitteRepository){
            return $this->json($QuitteRepository->getProfession_By_personne($id), 200, []);
        }
    }
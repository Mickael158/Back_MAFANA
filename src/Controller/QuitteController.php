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
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $famille = $data_decode['famille'];
            for($i = 0 ; $i < count($famille) ; $i++) {
                $Quitte = new Quitte();
                $personne = $personneMembreRepository->find($famille[$i]['id']);
                $Quitte->setIdPersonneMembre($personne);
                $Quitte->setDate(new \DateTime());
                $em->persist($Quitte);
                $em->flush();
            }
            return $this->json(['message' => 'Personne Membre Profession inserer'], 200, []);
        }

        #[Route('/api/restorer/{id}',name:'selectAll_Association',methods:'POST')]
        public function restorer($id ,EntityManagerInterface $em, PersonneMembreRepository $personneMembreRepository, QuitteRepository $quitteRepository){
            $personne = $personneMembreRepository->find($id);
            $quitte = $quitteRepository->findBy(['id_personne_membre' => $personne]);
            $em->remove($quitte[0]);
            $em->flush();
            return $this->json(['message' => 'Personne restaurer'], 200, []);
        }
    }
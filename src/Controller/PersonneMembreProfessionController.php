<?php
    namespace App\Controller;

use App\Entity\PersonneMembre;
use App\Entity\PersonneMembreProfession;
use App\Entity\Profession;
use App\Repository\PersonneMembreProfessionRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\ProfessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_MEMBRE")'))]
    class PersonneMembreProfessionController extends AbstractController{
        #[Route('/api/PersonneMembreProfession',name:'insetion_PersonneMembreProfession',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em , PersonneMembreRepository $personneMembreRepository , ProfessionRepository $professionRepository){
            $PersonneMembreProfession = new PersonneMembreProfession();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $personne = $personneMembreRepository->find($data_decode['IdPersonneMembre']);
            $profession = $professionRepository->find($data_decode['IdProfession']);
            $PersonneMembreProfession->setIdPersonneMembre($personne);
            $PersonneMembreProfession->setIdProfession($profession);
            $em->persist($PersonneMembreProfession);
            $em->flush();
            return $this->json(['message' => 'Personne Membre Profession inserer'], 200, []);
        }
        #[Route('/api/PersonneMembreProfessions/{id}',name:'selectAll_Associations',methods:'GET')]
        public function selectAlls(int $id , PersonneMembreProfessionRepository $personneMembreProfessionRepository){
            return $this->json($personneMembreProfessionRepository->getProfessionNot_By_personne($id), 200, []);
        }
    }
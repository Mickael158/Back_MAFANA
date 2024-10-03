<?php
    namespace App\Controller;

use App\Entity\DemandeFinancier;
use App\Repository\DemandeFinancierRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\UsersRepository;
use App\Service\TresorerieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_DEMANDE")'))]
    class DemandeFinancierController extends AbstractController{

        #[Route('/api/DemandeFinancier',name:'insetion_DemandeFinancier',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em ,PersonneMembreRepository $personneMembreRepository,TresorerieService $tresorerieService){
            $DemandeFinancier = new DemandeFinancier();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $personne = $personneMembreRepository->find($data_decode['id_personne_membre_id']);
            $DemandeFinancier->setIdPersonneMembre($personne);
            $DemandeFinancier->setDateDemandeFinancier(new \DateTime());
            $DemandeFinancier->setMontant($data_decode['montant']);
            $DemandeFinancier->setMotif($data_decode['motif']);
            $em->persist($DemandeFinancier);
            $em->flush();

            $tresorerieService->insert($DemandeFinancier->getMontant());
            return $this->json(['message' => 'DemandeFinancier inserer'], 200, []);
        }
        #[Route('/api/teste',name:'selectAll_Charge',methods:'GET')]
        public function selectAll(DemandeFinancierRepository $demandeFinancierRepository){
            return $this->json($demandeFinancierRepository->calculatePercentage(0), 200, []);
        }
    }
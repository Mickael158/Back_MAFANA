<?php
namespace App\Controller;

use App\Entity\PrixCotisation;
use App\Repository\PrixCotisationRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PrixCotisationController extends AbstractController
{
    #[Route('/api/PrixCotisation', name: 'insertion_PrixCotisation', methods: ['POST'])]
    public function inserer(Request $request, EntityManagerInterface $em, UsersRepository $usersRepository)
    {
        $PrixCotisation = new PrixCotisation();
        $data = $request->getContent();
        $data_decode = json_decode($data, true);

        // Récupération de l'utilisateur de la session
        $Utilisateur = $usersRepository->find($data_decode['Utilisateur']);

        if ($Utilisateur) {
            $PrixCotisation->setValeur($data_decode['Valeur'])
                ->setDateModif(new \DateTime($data_decode['DateModif']))
                ->setIdUtilisateur($Utilisateur);

            $em->persist($PrixCotisation);
            $em->flush();

            return $this->json(['message' => 'Prix Cotisation inséré'], 200, []);
        } else {
            return $this->json(['message' => 'Utilisateur non authentifié'], 403, []);
        }
    }

    #[Route('/api/PrixCotisation', name: 'selectAll_PrixCotisation', methods: ['GET'])]
    public function selectAll(PrixCotisationRepository $PrixCotisationRepository)
    {
        return $this->json($PrixCotisationRepository->findAll(), 200, []);
    }

    #[Route('/api/PrixCotisation/{id}', name: 'selectId_PrixCotisation', methods: ['GET'])]
    public function selectById($id, PrixCotisationRepository $PrixCotisationRepository)
    {
        return $this->json($PrixCotisationRepository->find($id), 200, []);
    }
    #[Route('/api/laste', name: 'select_laste', methods: ['GET'])]
    public function laste(PrixCotisationRepository $PrixCotisationRepository)
    {
        $date_debut = new \DateTime('2024-01-01');
        return $this->json($PrixCotisationRepository->getLastPrix_by_Date($date_debut), 200, []);
    }
}

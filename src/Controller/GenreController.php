<?php
    namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

    class GenreController extends AbstractController{

        #[Route('/api/Genre',name:'selectAll_Genre',methods:'GET')]
        public function selectAll(GenreRepository $GenreRepository){
            return $this->json($GenreRepository->findAll(), 200, []);
        }

        #[Route('/api/Genre/{id}',name:'selectId_Genre',methods:'GET')]
        public function selectById($id,GenreRepository $GenreRepository){
            return $this->json($GenreRepository->find($id), 200, []);
        }
        #[Route('/api/Genre',name:'insetion_Genre',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em){
            $Genre = new Genre();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Genre->setNomGenre($data_decode['Nom_Genre']);
            $em->persist($Genre);
            $em->flush();
            return $this->json(['message' => 'Genre inserer'], 200, []);
        }
    }
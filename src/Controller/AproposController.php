<?php
    namespace App\Controller;

use App\Entity\Apropos;
use App\Repository\AproposRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

   
    class AproposController extends AbstractController{
        
        #[Route('/api/Apropos/{id}',name:'modification_Apropos',methods:'POST')]
        public function modifier(Apropos $Apropos,Request $request, EntityManagerInterface $em){
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Apropos->setMots($data_decode['Mots']);
            $em->flush();
            return $this->json(['message' => 'Apropos modifier'], 200, []);
        }
        #[Route('/api/Aproposs/{id}',name:'selectAlls_Apropos',methods:'GET')]
        public function selectAlls(int $id , AproposRepository $AproposRepository){
            return $this->json($AproposRepository->find($id), 200, []);
        }
    }
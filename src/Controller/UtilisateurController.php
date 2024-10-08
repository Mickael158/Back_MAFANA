<?php
namespace App\Controller;

use App\Entity\Suivis;
use App\Entity\Users;
use App\Repository\PersonneMembreRepository;
use App\Repository\RoleRepository;
use App\Repository\RoleSuspenduRepository;
use App\Repository\UtilisateurMembreRepository;
use App\Repository\UsersRepository;
use App\Service\RoleSuspensionService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UtilisateurController extends AbstractController
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher,private readonly PersonneMembreRepository $personneRepository, private readonly RoleRepository $roleRepository)
    {
        
    }
    #[Route('/api/Utilisateur',name:'insetion_Utilisateur',methods:'POST')]
        public function inerer(Request $request, EntityManagerInterface $em,RoleRepository $roleRepository , PersonneMembreRepository $personneMembreRepository){
            $Utilisateur = new Users();
            $data = $request->getContent();
            $data_decode = json_decode($data, true);
            $Role=$data_decode['Role'];
            $ListeRole = [];
            $Personne = $personneMembreRepository->find($data_decode['idPersonne']);
            $Utilisateur
                ->setIdPersonne($Personne)
                ->setUsername($data_decode['username'])
                ->setPassword($this->hasher->hashPassword($Utilisateur, $data_decode['Password']));
            for($i=0;$i < count($Role);$i++){
                $data = $roleRepository->find($Role[$i]);
                $Utilisateur->setRoles(['ROLE_'.$data->getNomRole()]);
                foreach ($Utilisateur->getRoles() as $value) {
                    $ListeRole[] = $value;
                }
            };
            $Utilisateur->setRoles($ListeRole);
            $em->persist($Utilisateur);
            $em->flush();
            return $this->json(['message' => 'Utilisateur inserer'], 200, []);
        }

    #[Route('/api/login', name: 'login', methods: ['POST'])]
    public function Authentification()
    {
        
    }

    #[Route('/api/decode', name: 'decode', methods: ['POST'])]
    public function decodeToken(JWTEncoderInterface $jWTEncoderInterface,Request $request)
    {   
        $data= $request->getContent();
        $data_decode = json_decode($data, true);
        try {
            $decodedData = $jWTEncoderInterface->decode($data_decode['token']);
            return $this->json($decodedData['roles'],200,[]);
        } catch (\Exception $e) {
            return null;
        }
    }

   
    


    #[Route('/api/session-user', name: 'session_user', methods: ['GET'])]
    public function printSessionUser(SessionInterface $SESSION): Response
    {
        $user = $SESSION->get('user');
        if ($user) {
            $userJson = json_encode($user);
            return new Response($userJson, 200, ['Content-Type' => 'application/json']);
        } else {
            return new Response('Aucun utilisateur dans la session.', 404);
        }
    }

    #[Route('/api/AllUtilisateur',name:'all_user',methods:['GET'])]
    public function SelectAllUser(UsersRepository $usersRepository):JsonResponse
    {
        return $this->json($usersRepository->findAll());
    }

    #[Route('/api/AttributionRole/{id}',name:'attribution_role',methods:['POST'])]
    public function AttributionRole(Users $users,EntityManagerInterface $em,Request $request,RoleRepository $roleRepository,JWTEncoderInterface $jWTEncoderInterface,UsersRepository $usersRepository):JsonResponse
    {
        $data = $request->getContent();
        $data_decode = json_decode($data, true);
        $role = $data_decode['roles'];
        $chaine = '';
        foreach ($role as $value) {
            $result = $roleRepository->find($value);
            $chaine = $chaine . ' ' . $result->getNomRole();
        }
        $token = $data_decode['token'];
        $decode = $jWTEncoderInterface->decode($token);
        $Administrateur = $usersRepository->findOneBy(['username'=>$decode['username']]);
        $suivis = new Suivis();
        $suivis
            ->setAdministrateurId($Administrateur)
            ->setDateAttribution(new \DateTime())
            ->setRole($chaine)
            ->setUtilisateurId($users);
        $em->persist($suivis);
        $em->flush($suivis);
        $ListeRole = [];
            for($i=0;$i < count($role);$i++){
                $data = $roleRepository->find($role[$i]);
                $users->setRoles(['ROLE_'.$data->getNomRole()]);
                foreach ($users->getRoles() as $value) {
                    $ListeRole[] = $value;
                }
            };
        $users->setRoles($ListeRole);
        $em->flush();
        return $this->json(['message' => 'Utilisateur inserer'], 200, []);
    }
}

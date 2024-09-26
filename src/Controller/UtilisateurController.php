<?php
namespace App\Controller;

use App\Entity\Users;
use App\Repository\PersonneMembreRepository;
use App\Repository\RoleRepository;
use App\Repository\UtilisateurMembreRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

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
            $Role = $roleRepository->find($data_decode['idRole']);
            $Personne = $personneMembreRepository->find($data_decode['idPersonne']);
            $Utilisateur
                ->setIdRole($Role)
                ->setIdPersonne($Personne)
                ->setUsername($data_decode['username'])
                ->setPassword($this->hasher->hashPassword($Utilisateur, $data_decode['Password']))
                ->setRoles([$Role->getNomRole()])
                ->setToken($this->hasher->hashPassword($Utilisateur, $data_decode['Password']));
            $em->persist($Utilisateur);
            $em->flush();
            return $this->json(['message' => 'Utilisateur inserer'], 200, []);
        }
    // #[Route('/api/login', name: 'login', methods: ['POST'])]
    // public function Authentification(UsersRepository $UserRepository, Request $Request, PersonneMembreRepository $PersonneMembreRepository , JWTTokenManagerInterface $jWTTokenManagerInterface,UserPasswordHasherInterface $hasher)
    // {
    //     $data = $Request->getContent();
    //     $data_decode = json_decode($data, true);
    //     $username = $data_decode['username'];
    //     $password = $data_decode['password'];
    //     $Utilisateur = $UserRepository->findOneBy(['username' => $username]);
    //     if ($Utilisateur) {
    //         if($hasher->isPasswordValid($Utilisateur, $password)){
    //             $userInterfacem = new UtilisateurCustom();
    //             $userInterfacem->setUsername($Utilisateur->getUsername());
    //             $userInterfacem->setPassword($Utilisateur->getPassword());
    //             $userInterfacem->setRoles($Utilisateur->getRoles());
    //             $token = $jWTTokenManagerInterface->create($Utilisateur);
    //             return $this->json($token, 200, []);
    //         }else{
    //             return $this->json(['message' => 'Votre mot de passe est incorrect.'], 403, []);
    //         }
    //     } else {
    //         return $this->json(['message' => 'Username incorrect.'], 403, []);
    //     }
    // }
    #[Route('/api/login', name: 'login', methods: ['POST'])]
    public function Authentification(JWTEncoderInterface $jWTEncoderInterface,UsersRepository $UserRepository, Request $Request, PersonneMembreRepository $PersonneMembreRepository , JWTTokenManagerInterface $jWTTokenManagerInterface,UserPasswordHasherInterface $hasher)
    {
        $data = $Request->getContent();
        $data_decode = json_decode($data, true);
        $username = $data_decode['username'];
        $password = $data_decode['password'];
        $Utilisateur = $UserRepository->findOneBy(['username' => $username]);
        if ($Utilisateur) {
            if($hasher->isPasswordValid($Utilisateur, $password)){
                $token = $jWTTokenManagerInterface->create($Utilisateur);
                $decodedData = $jWTEncoderInterface->decode($token);
                return $this->json(['data' => $decodedData], 200, []);
            }else{
                return $this->json(['message' => 'Votre mot de passe est incorrect.'], 403, []);
            }
        } else {
            return $this->json(['message' => 'Username incorrect.'], 403, []);
        }
    }
    // public function decodeToken(JWTEncoderInterface $jWTEncoderInterface, string $token)
    // {
    //     try {
    //         $decodedData = $jWTEncoderInterface->decode($token);
    //         return $decodedData;
    //     } catch (\Exception $e) {
    //         // Gestion des erreurs, par exemple token invalide
    //         return null;
    //     }
    // }

    #[Route('/api/session-user', name: 'session_user', methods: ['GET'])]
    public function printSessionUser(SessionInterface $SESSION): Response
    {
        // Récupérer l'utilisateur stocké dans la session
        $user = $SESSION->get('user');

        // Vérifier si l'utilisateur est présent dans la session
        if ($user) {
            // Convertir l'utilisateur en JSON pour l'affichage
            $userJson = json_encode($user);

            // Retourner la réponse JSON
            return new Response($userJson, 200, ['Content-Type' => 'application/json']);
        } else {
            return new Response('Aucun utilisateur dans la session.', 404);
        }
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Repository\PersonneMembreRepository;
use App\Repository\RoleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher,private readonly PersonneMembreRepository $personneRepository, private readonly RoleRepository $roleRepository)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        $user = new Users();
        $role = $this->roleRepository->find(1);
        $personne = $this->personneRepository->find(2);
        $user
            ->setUsername('Administrateur')
            ->setPassword($this->hasher->hashPassword($user,'123456'))
            ->setIdPersonne($personne)
            ->setIdRole($role)
            ->setRoles([$role->getNomRole()])
            ;
        $manager->persist($user);
        $manager->flush();
    }
}

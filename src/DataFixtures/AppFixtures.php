<?php

namespace App\DataFixtures;

use App\Entity\Apropos;
use App\Entity\Association;
use App\Entity\Genre;
use App\Entity\PersonneMembre;
use App\Entity\QuiSommeNous;
use App\Entity\Role;
use App\Entity\Users;
use App\Entity\Vallee;
use App\Entity\Village;
use App\Repository\GenreRepository;
use App\Repository\PersonneMembreRepository;
use App\Repository\ProfessionRepository;
use App\Repository\RoleRepository;
use App\Repository\ValleeRepository;
use App\Repository\VillageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher,private readonly PersonneMembreRepository $personneRepository, private readonly RoleRepository $roleRepository,private readonly VillageRepository $villageRepository,private readonly ValleeRepository $valleRepository,private readonly GenreRepository $genreRepository,private readonly ProfessionRepository $professionRepository)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        $role = new Role();
        $role->setNomRole('ADMIN');
        $manager->persist($role);
        $manager->flush();

        $genre = new Genre();
        $genre->setNomGenre('Homme');
        $manager->persist($genre);
        $manager->flush();

        $genre = new Genre();
        $genre->setNomGenre('Femme');
        $manager->persist($genre);
        $manager->flush();

        $valle = new Vallee();
        $valle->setNomVallee('MANAGNANO');
        $manager->persist($valle);
        $manager->flush();

        $idValle = $this->valleRepository->findAll();
        $village = new Village();
        $village->setNomVillage('managnano1')
        ->setIdVallee($idValle[0]);
        $manager->persist($village);
        $manager->flush();


        $idVillage = $this->villageRepository->findAll();
        $idGenre = $this->genreRepository->findAll();
        $personne = new PersonneMembre();
        $personne
            ->setNomMembre('RAHERIMANANA')
            ->setAddress('FAIV 410 B')
            ->setDateDeNaissance(new \DateTime('2004-10-28'))
            ->setDateInscription(new \DateTime())
            ->setEmail('zosephatoky@gmail.com')
            ->setAddressTana("Adresse")
            ->setFokotany("Fokotany")
            ->setCIN("123456789456")
            ->setArrondissement("1ere Arrodissement")
            ->setPrenomMembre('Toky')
            ->setIdVillage($idVillage[0])
            ->setIdGenre($idGenre[0]);
        $manager->persist($personne);
        $manager->flush();
        $user = new Users();
        $idRole = $this->roleRepository->findAll();
        $idPersonne = $this->personneRepository->findAll();
        $user
            ->setUsername('Administrateur')
            ->setPassword($this->hasher->hashPassword($user,'123456'))
            ->setIdPersonne($idPersonne[0])
            ->setRoles(['ROLE_'.$idRole[0]->getNomRole()])
            ;
        $manager->persist($user);
        $manager->flush();

        $association = new Association();
        $association
            ->setNom('MA.FA.NA')
            ->setSiege('Avaradoha')
            ->setDateCreation(new \DateTime)
            ->setDescription('Association mafana')
            ->setEmail('mafana@gmail.com')
            ->setTelephone('0343562462')
            ->setSecteurActivite('Activite')
            ->setSlogan('Pour le peuple')
            ->setNatureJuridique('Nature juridique')
            ->setLogo('Logo');
        $manager->persist($association);
        $manager->flush();

        $Apropos = new Apropos();
        $Apropos->setMots('Mot de professeur');
        $manager->persist($Apropos);
        $manager->flush();

    }
}

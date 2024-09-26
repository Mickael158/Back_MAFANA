<?php

namespace App\Entity;

use App\Repository\PersonneMembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneMembreRepository::class)]
class PersonneMembre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $Nom_Membre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_de_Naissance = null;

    #[ORM\Column(length: 500)]
    private ?string $Address = null;

    #[ORM\Column(length: 5000)]
    private ?string $Email = null;

    #[ORM\Column(length: 500)]
    private ?string $Telephone = null;

    #[ORM\Column(length: 500)]
    private ?string $Prenom_Membre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Village $Id_Village = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $Id_Genre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Inscription = null;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMembre(): ?string
    {
        return $this->Nom_Membre;
    }

    public function setNomMembre(string $Nom_Membre): static
    {
        $this->Nom_Membre = $Nom_Membre;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->Date_de_Naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $Date_de_Naissance): static
    {
        $this->Date_de_Naissance = $Date_de_Naissance;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): static
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getPrenomMembre(): ?string
    {
        return $this->Prenom_Membre;
    }

    public function setPrenomMembre(string $Prenom_Membre): static
    {
        $this->Prenom_Membre = $Prenom_Membre;

        return $this;
    }

    public function getIdVillage(): ?Village
    {
        return $this->Id_Village;
    }

    public function setIdVillage(?Village $Id_Village): static
    {
        $this->Id_Village = $Id_Village;

        return $this;
    }

    public function getIdGenre(): ?genre
    {
        return $this->Id_Genre;
    }

    public function setIdGenre(?genre $Id_Genre): static
    {
        $this->Id_Genre = $Id_Genre;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->Date_Inscription;
    }

    public function setDateInscription(\DateTimeInterface $Date_Inscription): static
    {
        $this->Date_Inscription = $Date_Inscription;

        return $this;
    }

}

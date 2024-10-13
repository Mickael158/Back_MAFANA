<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssociationRepository::class)]
class Association
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $Nom = null;

    #[ORM\Column(length: 200)]
    private ?string $Siege = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Creation = null;

    #[ORM\Column(length: 500)]
    private ?string $Description = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $Email = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $Telephone = null;

    #[ORM\Column(length: 500)]
    private ?string $Secteur_Activite = null;

    #[ORM\Column(length: 500)]
    private ?string $Nature_Juridique = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $Slogan = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $Logo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->Siege;
    }

    public function setSiege(string $Siege): static
    {
        $this->Siege = $Siege;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->Date_Creation;
    }

    public function setDateCreation(\DateTimeInterface $Date_Creation): static
    {
        $this->Date_Creation = $Date_Creation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(?string $Telephone): static
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getSecteurActivite(): ?string
    {
        return $this->Secteur_Activite;
    }

    public function setSecteurActivite(string $Secteur_Activite): static
    {
        $this->Secteur_Activite = $Secteur_Activite;

        return $this;
    }

    public function getNatureJuridique(): ?string
    {
        return $this->Nature_Juridique;
    }

    public function setNatureJuridique(string $Nature_Juridique): static
    {
        $this->Nature_Juridique = $Nature_Juridique;

        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->Slogan;
    }

    public function setSlogan(?string $Slogan): static
    {
        $this->Slogan = $Slogan;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->Logo;
    }

    public function setLogo(?string $Logo): static
    {
        $this->Logo = $Logo;

        return $this;
    }
}


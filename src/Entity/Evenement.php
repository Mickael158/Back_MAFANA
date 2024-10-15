<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $Description_Evenement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Publication = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_Evenement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_fin_Evenement = null;

    #[ORM\Column(length: 500)]
    private ?string $Lieu_Evenement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $Id_Utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeEvenement $Id_Type_Evenement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Association $Id_Association = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column]
    private ?bool $publier = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionEvenement(): ?string
    {
        return $this->Description_Evenement;
    }

    public function setDescriptionEvenement(string $Description_Evenement): static
    {
        $this->Description_Evenement = $Description_Evenement;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->Date_Publication;
    }

    public function setDatePublication(\DateTimeInterface $Date_Publication): static
    {
        $this->Date_Publication = $Date_Publication;

        return $this;
    }

    public function getDateEvenement(): ?\DateTimeInterface
    {
        return $this->Date_Evenement;
    }

    public function setDateEvenement(\DateTimeInterface $Date_Evenement): static
    {
        $this->Date_Evenement = $Date_Evenement;

        return $this;
    }

    public function getDateFinEvenement(): ?\DateTimeInterface
    {
        return $this->Date_fin_Evenement;
    }

    public function setDateFinEvenement(\DateTimeInterface $Date_fin_Evenement): static
    {
        $this->Date_fin_Evenement = $Date_fin_Evenement;

        return $this;
    }

    public function getLieuEvenement(): ?string
    {
        return $this->Lieu_Evenement;
    }

    public function setLieuEvenement(string $Lieu_Evenement): static
    {
        $this->Lieu_Evenement = $Lieu_Evenement;

        return $this;
    }

    public function getIdUtilisateur(): ?users
    {
        return $this->Id_Utilisateur;
    }

    public function setIdUtilisateur(?users $Id_Utilisateur): static
    {
        $this->Id_Utilisateur = $Id_Utilisateur;

        return $this;
    }

    public function getIdTypeEvenement(): ?TypeEvenement
    {
        return $this->Id_Type_Evenement;
    }

    public function setIdTypeEvenement(?TypeEvenement $Id_Type_Evenement): static
    {
        $this->Id_Type_Evenement = $Id_Type_Evenement;

        return $this;
    }

    public function getIdAssociation(): ?Association
    {
        return $this->Id_Association;
    }

    public function setIdAssociation(?Association $Id_Association): static
    {
        $this->Id_Association = $Id_Association;

        return $this;
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

    public function isPublier(): ?bool
    {
        return $this->publier;
    }

    public function setPublier(bool $publier): static
    {
        $this->publier = $publier;

        return $this;
    }
}

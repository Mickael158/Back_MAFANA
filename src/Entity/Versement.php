<?php

namespace App\Entity;

use App\Repository\VersementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersementRepository::class)]
class Versement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Versement = null;

    #[ORM\Column]
    private ?float $Montant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $id_Utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeRevenu $id_Revenu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVersement(): ?\DateTimeInterface
    {
        return $this->Date_Versement;
    }

    public function setDateVersement(\DateTimeInterface $Date_Versement): static
    {
        $this->Date_Versement = $Date_Versement;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getIdUtilisateur(): ?users
    {
        return $this->id_Utilisateur;
    }

    public function setIdUtilisateur(?users $id_Utilisateur): static
    {
        $this->id_Utilisateur = $id_Utilisateur;

        return $this;
    }

    public function getIdRevenu(): ?TypeRevenu
    {
        return $this->id_Revenu;
    }

    public function setIdRevenu(?TypeRevenu $id_Revenu): static
    {
        $this->id_Revenu = $id_Revenu;

        return $this;
    }
}

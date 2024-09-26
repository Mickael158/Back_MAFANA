<?php

namespace App\Entity;

use App\Repository\ValidationDemandeFinancierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValidationDemandeFinancierRepository::class)]
class ValidationDemandeFinancier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Validation = null;

    #[ORM\ManyToOne]
    private ?DemandeFinancier $Id_DemandeFinancier = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $Id_Utilisateur = null;

    #[ORM\Column]
    private ?float $Montant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->Date_Validation;
    }

    public function setDateValidation(\DateTimeInterface $Date_Validation): static
    {
        $this->Date_Validation = $Date_Validation;

        return $this;
    }

    public function getIdDemandeFinancier(): ?DemandeFinancier
    {
        return $this->Id_DemandeFinancier;
    }

    public function setIdDemandeFinancier(?DemandeFinancier $Id_DemandeFinancier): static
    {
        $this->Id_DemandeFinancier = $Id_DemandeFinancier;

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

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }
}

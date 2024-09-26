<?php

namespace App\Entity;

use App\Repository\DemandeFinancierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeFinancierRepository::class)]
class DemandeFinancier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Demande_Financier = null;

    #[ORM\Column]
    private ?float $Montant = null;

    #[ORM\ManyToOne(inversedBy: 'demandeFinanciers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Id_Personne_Membre = null;

    #[ORM\Column(length: 255)]
    private ?string $Motif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDemandeFinancier(): ?\DateTimeInterface
    {
        return $this->Date_Demande_Financier;
    }

    public function setDateDemandeFinancier(\DateTimeInterface $Date_Demande_Financier): static
    {
        $this->Date_Demande_Financier = $Date_Demande_Financier;

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

    public function getIdPersonneMembre(): ?PersonneMembre
    {
        return $this->Id_Personne_Membre;
    }

    public function setIdPersonneMembre(?PersonneMembre $Id_Personne_Membre): static
    {
        $this->Id_Personne_Membre = $Id_Personne_Membre;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->Motif;
    }

    public function setMotif(string $Motif): static
    {
        $this->Motif = $Motif;

        return $this;
    }
}

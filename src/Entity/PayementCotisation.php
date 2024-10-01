<?php

namespace App\Entity;

use App\Repository\PayementCotisationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PayementCotisationRepository::class)]
class PayementCotisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_De_Payement = null;

    #[ORM\Column]
    private ?float $Montant_Cotisation_Total_Payer = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_payer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $Id_Utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Id_Personne_Membre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDePayement(): ?\DateTimeInterface
    {
        return $this->Date_De_Payement;
    }

    public function setDateDePayement(\DateTimeInterface $Date_De_Payement): static
    {
        $this->Date_De_Payement = $Date_De_Payement;

        return $this;
    }

    public function getMontantCotisationTotalPayer(): ?float
    {
        return $this->Montant_Cotisation_Total_Payer;
    }

    public function setMontantCotisationTotalPayer(float $Montant_Cotisation_Total_Payer): static
    {
        $this->Montant_Cotisation_Total_Payer = $Montant_Cotisation_Total_Payer;

        return $this;
    }

    public function getDatePayer(): ?\DateTimeInterface
    {
        return $this->Date_payer;
    }

    public function setDatePayer(\DateTimeInterface $Date_payer): static
    {
        $this->Date_payer = $Date_payer;

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

    public function getIdPersonneMembre(): ?PersonneMembre
    {
        return $this->Id_Personne_Membre;
    }

    public function setIdPersonneMembre(?PersonneMembre $Id_Personne_Membre): static
    {
        $this->Id_Personne_Membre = $Id_Personne_Membre;

        return $this;
    }
}

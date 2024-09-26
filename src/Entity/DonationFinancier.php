<?php

namespace App\Entity;

use App\Repository\DonationFinancierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonationFinancierRepository::class)]
class DonationFinancier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $Nom_Donation_Financier = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Donation_Financier = null;

    #[ORM\Column]
    private ?float $Montant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $Id_Utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDonationFinancier(): ?string
    {
        return $this->Nom_Donation_Financier;
    }

    public function setNomDonationFinancier(string $Nom_Donation_Financier): static
    {
        $this->Nom_Donation_Financier = $Nom_Donation_Financier;

        return $this;
    }

    public function getDateDonationFinancier(): ?\DateTimeInterface
    {
        return $this->Date_Donation_Financier;
    }

    public function setDateDonationFinancier(\DateTimeInterface $Date_Donation_Financier): static
    {
        $this->Date_Donation_Financier = $Date_Donation_Financier;

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
        return $this->Id_Utilisateur;
    }

    public function setIdUtilisateur(?users $Id_Utilisateur): static
    {
        $this->Id_Utilisateur = $Id_Utilisateur;

        return $this;
    }
}

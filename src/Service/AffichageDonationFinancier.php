<?php
namespace App\Service;

use App\Entity\PersonneMembre;
use DateTime;

class AffichageDonationFinancier
{
    private string $nom_donation_financier;
    private DateTime $date_donation_financier;
    private float $montant;
    private bool $status;

    // Getter et Setter pour $nom_donation_financier
    public function getNomDonationFinancier(): string
    {
        return $this->nom_donation_financier;
    }

    public function setNomDonationFinancier(string $nom_donation_financier): self
    {
        $this->nom_donation_financier = $nom_donation_financier;
        return $this;
    }

    // Getter et Setter pour $date_donation_financier
    public function getDateDonationFinancier(): DateTime
    {
        return $this->date_donation_financier;
    }

    public function setDateDonationFinancier(DateTime $date_donation_financier): self
    {
        $this->date_donation_financier = $date_donation_financier;
        return $this;
    }

    // Getter et Setter pour $montant
    public function getMontant(): float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    // Getter et Setter pour $status
    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }
}

<?php
namespace App\Service;

use App\Entity\DemandeFinancier;
use App\Entity\DemandeMateriel;
use App\Entity\PersonneMembre;

class InvestigationFinancier {
    private PersonneMembre $Personn_membre;
    private float $Montant;
    private string $motif;
    private float $pourcentage;
    private DemandeFinancier $Demande_financier;

    public function getDemandefinancier(): DemandeFinancier {
        return $this->Demande_financier;
    }

    public function setDemandefinancier(DemandeFinancier $demandeFinancier): self {
        $this->Demande_financier = $demandeFinancier;
        return $this;
    }
    // Getter and Setter for $Personn_membre
    public function getPersonnMembre(): PersonneMembre {
        return $this->Personn_membre;
    }

    public function setPersonnMembre(PersonneMembre $Personn_membre): self {
        $this->Personn_membre = $Personn_membre;
        return $this;
    }

    // Getter and Setter for $Montant
    public function getMontant(): float {
        return $this->Montant;
    }

    public function setMontant(float $Montant): self {
        $this->Montant = $Montant;
        return $this;
    }

    // Getter and Setter for $motif
    public function getMotif(): string {
        return $this->motif;
    }

    public function setMotif(string $motif): self {
        $this->motif = $motif;
        return $this;
    }

    // Getter and Setter for $pourcentage
    public function getPourcentage(): float {
        return $this->pourcentage;
    }

    public function setPourcentage(float $pourcentage): self {
        $this->pourcentage = $pourcentage;
        return $this;
    }
}
?>

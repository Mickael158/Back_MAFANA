<?php
namespace App\Service;

use App\Entity\PersonneMembre;
use DateTime;

class Devis {
    private PersonneMembre $Personn_membre;
    private DateTime $Date_payer;
    private float $Montant;

    // Getter et Setter pour Personn_membre
    public function getPersonnMembre(): PersonneMembre {
        return $this->Personn_membre;
    }

    public function setPersonnMembre(PersonneMembre $Personn_membre): void {
        $this->Personn_membre = $Personn_membre;
    }

    // Getter et Setter pour Date_payer
    public function getDatePayer(): DateTime {
        return $this->Date_payer;
    }

    public function setDatePayer(DateTime $Date_payer): void {
        $this->Date_payer = $Date_payer;
    }

    // Getter et Setter pour Montant
    public function getMontant(): float {
        return $this->Montant;
    }

    public function setMontant(float $Montant): void {
        $this->Montant = $Montant;
    }
}
?>

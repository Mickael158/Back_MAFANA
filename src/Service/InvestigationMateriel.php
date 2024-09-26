<?php
namespace App\Service;

use App\Entity\DemandeMateriel;
use App\Entity\PersonneMembre;

class InvestigationMateriel {
    private PersonneMembre $Personn_membre;
    private float $Nombre;
    private string $motif;
    private float $pourcentage;
    private DemandeMateriel $Demande_Materiel;

    public function getDemandeMateriel(): DemandeMateriel {
        return $this->Demande_Materiel;
    }

    public function setDemandeMateriel(DemandeMateriel $demandeMateriel): self {
        $this->Demande_Materiel = $demandeMateriel;
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

    // Getter and Setter for $Nombre
    public function getNombre(): float {
        return $this->Nombre;
    }

    public function setNombre(float $Nombre): self {
        $this->Nombre = $Nombre;
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

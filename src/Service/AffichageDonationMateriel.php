<?php
namespace App\Service;

use App\Entity\PersonneMembre;
use DateTime;

class AffichageDonationMateriel
{
    private string $nom_donnateur_materiel;
    private string $nom_materiel;
    private DateTime $date_acquisition;
    private int $nombre;
    private bool $status;

    // Getters and Setters

    public function getNomDonnateurMateriel(): string
    {
        return $this->nom_donnateur_materiel;
    }

    public function setNomDonnateurMateriel(string $nom_donnateur_materiel): void
    {
        $this->nom_donnateur_materiel = $nom_donnateur_materiel;
    }

    public function getNomMateriel(): string
    {
        return $this->nom_materiel;
    }

    public function setNomMateriel(string $nom_materiel): void
    {
        $this->nom_materiel = $nom_materiel;
    }

    public function getDateAcquisition(): DateTime
    {
        return $this->date_acquisition;
    }

    public function setDateAcquisition(DateTime $date_acquisition): void
    {
        $this->date_acquisition = $date_acquisition;
    }

    public function getNombre(): int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }
}

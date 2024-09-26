<?php

namespace App\Entity;

use App\Repository\DemandeMaterielRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeMaterielRepository::class)]
class DemandeMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_de_Demande = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Id_Personne_Membre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materiel $Id_Materiel = null;

    #[ORM\Column(length: 255)]
    private ?string $Motif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?int
    {
        return $this->Nombre;
    }

    public function setNombre(int $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getDateDeDemande(): ?\DateTimeInterface
    {
        return $this->Date_de_Demande;
    }

    public function setDateDeDemande(\DateTimeInterface $Date_de_Demande): static
    {
        $this->Date_de_Demande = $Date_de_Demande;

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

    public function getIdMateriel(): ?materiel
    {
        return $this->Id_Materiel;
    }

    public function setIdMateriel(?materiel $Id_Materiel): static
    {
        $this->Id_Materiel = $Id_Materiel;

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

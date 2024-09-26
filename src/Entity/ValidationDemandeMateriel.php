<?php

namespace App\Entity;

use App\Repository\ValidationDemandeMaterielRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValidationDemandeMaterielRepository::class)]
class ValidationDemandeMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_de_Validation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $Id_Utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?DemandeMateriel $Id_Demande_Materiel = null;

    #[ORM\Column]
    private ?int $nombre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDeValidation(): ?\DateTimeInterface
    {
        return $this->Date_de_Validation;
    }

    public function setDateDeValidation(\DateTimeInterface $Date_de_Validation): static
    {
        $this->Date_de_Validation = $Date_de_Validation;

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

    public function getIdDemandeMateriel(): ?DemandeMateriel
    {
        return $this->Id_Demande_Materiel;
    }

    public function setIdDemandeMateriel(?DemandeMateriel $Id_Demande_Materiel): static
    {
        $this->Id_Demande_Materiel = $Id_Demande_Materiel;

        return $this;
    }

    public function getNombre(): ?int
    {
        return $this->nombre;
    }

    public function setNombre(int $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }
}

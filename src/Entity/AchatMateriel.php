<?php

namespace App\Entity;

use App\Repository\AchatMaterielRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchatMaterielRepository::class)]
class AchatMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Achat_Materiel = null;

    #[ORM\Column]
    private ?float $Valeur = null;

    #[ORM\Column]
    private ?int $Nombre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materiel $Id_Materiel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAchatMateriel(): ?\DateTimeInterface
    {
        return $this->Date_Achat_Materiel;
    }

    public function setDateAchatMateriel(\DateTimeInterface $Date_Achat_Materiel): static
    {
        $this->Date_Achat_Materiel = $Date_Achat_Materiel;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->Valeur;
    }

    public function setValeur(float $Valeur): static
    {
        $this->Valeur = $Valeur;

        return $this;
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

    public function getIdMateriel(): ?Materiel
    {
        return $this->Id_Materiel;
    }

    public function setIdMateriel(?Materiel $Id_Materiel): static
    {
        $this->Id_Materiel = $Id_Materiel;

        return $this;
    }
}

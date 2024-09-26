<?php

namespace App\Entity;

use App\Repository\VillageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VillageRepository::class)]
class Village
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $Nom_Village = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vallee $Id_Vallee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVillage(): ?string
    {
        return $this->Nom_Village;
    }

    public function setNomVillage(string $Nom_Village): static
    {
        $this->Nom_Village = $Nom_Village;

        return $this;
    }

    public function getIdVallee(): ?Vallee
    {
        return $this->Id_Vallee;
    }

    public function setIdVallee(?Vallee $Id_Vallee): static
    {
        $this->Id_Vallee = $Id_Vallee;

        return $this;
    }
}

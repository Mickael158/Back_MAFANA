<?php

namespace App\Entity;

use App\Repository\TypeEvenementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeEvenementRepository::class)]
class TypeEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $Nom_Type_Evenement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeEvenement(): ?string
    {
        return $this->Nom_Type_Evenement;
    }

    public function setNomTypeEvenement(string $Nom_Type_Evenement): static
    {
        $this->Nom_Type_Evenement = $Nom_Type_Evenement;

        return $this;
    }
}

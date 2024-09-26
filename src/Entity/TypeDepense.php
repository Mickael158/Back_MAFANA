<?php

namespace App\Entity;

use App\Repository\TypeDepenseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeDepenseRepository::class)]
class TypeDepense
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $Motif_Depense = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotifDepense(): ?string
    {
        return $this->Motif_Depense;
    }

    public function setMotifDepense(string $Motif_Depense): static
    {
        $this->Motif_Depense = $Motif_Depense;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TypeRevenuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRevenuRepository::class)]
class TypeRevenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $Motif_Revenu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotifRevenu(): ?string
    {
        return $this->Motif_Revenu;
    }

    public function setMotifRevenu(string $Motif_Revenu): static
    {
        $this->Motif_Revenu = $Motif_Revenu;

        return $this;
    }
}

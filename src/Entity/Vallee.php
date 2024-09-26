<?php

namespace App\Entity;

use App\Repository\ValleeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValleeRepository::class)]
class Vallee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $Nom_Vallee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVallee(): ?string
    {
        return $this->Nom_Vallee;
    }

    public function setNomVallee(string $Nom_Vallee): static
    {
        $this->Nom_Vallee = $Nom_Vallee;

        return $this;
    }
}

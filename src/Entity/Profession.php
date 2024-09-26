<?php

namespace App\Entity;

use App\Repository\ProfessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessionRepository::class)]
class Profession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $Nom_Profession = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProfession(): ?string
    {
        return $this->Nom_Profession;
    }

    public function setNomProfession(string $Nom_Profession): static
    {
        $this->Nom_Profession = $Nom_Profession;

        return $this;
    }
}

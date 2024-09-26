<?php

namespace App\Entity;

use App\Repository\CategorieMaterielRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieMaterielRepository::class)]
class CategorieMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $Nom_Categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->Nom_Categorie;
    }

    public function setNomCategorie(string $Nom_Categorie): static
    {
        $this->Nom_Categorie = $Nom_Categorie;

        return $this;
    }
}

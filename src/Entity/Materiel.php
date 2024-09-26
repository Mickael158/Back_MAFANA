<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $NomMateriel = null;

    #[ORM\ManyToOne] 
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieMateriel $Id_Categorie_Materiel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMateriel(): ?string
    {
        return $this->NomMateriel;
    }

    public function setNomMateriel(string $NomMateriel): static
    {
        $this->NomMateriel = $NomMateriel;

        return $this;
    }

    public function getIdCategorieMateriel(): ?CategorieMateriel
    {
        return $this->Id_Categorie_Materiel;
    }

    public function setIdCategorieMateriel(?CategorieMateriel $Id_Categorie_Materiel): static
    {
        $this->Id_Categorie_Materiel = $Id_Categorie_Materiel;

        return $this;
    }
}

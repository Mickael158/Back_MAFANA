<?php

namespace App\Entity;

use App\Repository\EnfantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnfantRepository::class)]
class Enfant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Id_Enfant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Mariage $Id_Mariage_Parent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEnfant(): ?PersonneMembre
    {
        return $this->Id_Enfant;
    }

    public function setIdEnfant(?PersonneMembre $Id_Enfant): static
    {
        $this->Id_Enfant = $Id_Enfant;

        return $this;
    }

    public function getIdMariageParent(): ?Mariage
    {
        return $this->Id_Mariage_Parent;
    }

    public function setIdMariageParent(?Mariage $Id_Mariage_Parent): static
    {
        $this->Id_Mariage_Parent = $Id_Mariage_Parent;

        return $this;
    }
}

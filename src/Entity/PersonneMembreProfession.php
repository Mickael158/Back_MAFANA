<?php

namespace App\Entity;

use App\Repository\PersonneMembreProfessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonneMembreProfessionRepository::class)]
class PersonneMembreProfession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Id_Personne_Membre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profession $Id_Profession = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPersonneMembre(): ?PersonneMembre
    {
        return $this->Id_Personne_Membre;
    }

    public function setIdPersonneMembre(?PersonneMembre $Id_Personne_Membre): static
    {
        $this->Id_Personne_Membre = $Id_Personne_Membre;

        return $this;
    }

    public function getIdProfession(): ?Profession
    {
        return $this->Id_Profession;
    }

    public function setIdProfession(?Profession $Id_Profession): static
    {
        $this->Id_Profession = $Id_Profession;

        return $this;
    }
}

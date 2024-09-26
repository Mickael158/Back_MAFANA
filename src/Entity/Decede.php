<?php

namespace App\Entity;

use App\Repository\DecedeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DecedeRepository::class)]
class Decede
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Dece = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Id_Personne_Membre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDece(): ?\DateTimeInterface
    {
        return $this->Date_Dece;
    }

    public function setDateDece(\DateTimeInterface $Date_Dece): static
    {
        $this->Date_Dece = $Date_Dece;

        return $this;
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
}

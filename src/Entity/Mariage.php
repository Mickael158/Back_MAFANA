<?php

namespace App\Entity;

use App\Repository\MariageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MariageRepository::class)]
class Mariage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Mariage = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Id_Mari = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Id_Marie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMariage(): ?\DateTimeInterface
    {
        return $this->Date_Mariage;
    }

    public function setDateMariage(\DateTimeInterface $Date_Mariage): static
    {
        $this->Date_Mariage = $Date_Mariage;

        return $this;
    }

    public function getIdMari(): ?PersonneMembre
    {
        return $this->Id_Mari;
    }

    public function setIdMari(?PersonneMembre $Id_Mari): static
    {
        $this->Id_Mari = $Id_Mari;

        return $this;
    }

    public function getIdMarie(): ?PersonneMembre
    {
        return $this->Id_Marie;
    }

    public function setIdMarie(?PersonneMembre $Id_Marie): static
    {
        $this->Id_Marie = $Id_Marie;

        return $this;
    }
}

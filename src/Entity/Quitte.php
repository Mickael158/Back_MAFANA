<?php

namespace App\Entity;

use App\Repository\QuitteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuitteRepository::class)]
class Quitte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?personneMembre $id_personne_membre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPersonneMembre(): ?personneMembre
    {
        return $this->id_personne_membre;
    }

    public function setIdPersonneMembre(?personneMembre $id_personne_membre): static
    {
        $this->id_personne_membre = $id_personne_membre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
}

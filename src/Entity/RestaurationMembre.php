<?php

namespace App\Entity;

use App\Repository\RestaurationMembreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurationMembreRepository::class)]
class RestaurationMembre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $id_personne_membre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_restauration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPersonneMembre(): ?PersonneMembre
    {
        return $this->id_personne_membre;
    }

    public function setIdPersonneMembre(?PersonneMembre $id_personne_membre): static
    {
        $this->id_personne_membre = $id_personne_membre;

        return $this;
    }

    public function getDateRestauration(): ?\DateTimeInterface
    {
        return $this->date_restauration;
    }

    public function setDateRestauration(\DateTimeInterface $date_restauration): static
    {
        $this->date_restauration = $date_restauration;

        return $this;
    }
}

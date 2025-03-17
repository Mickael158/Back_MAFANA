<?php

namespace App\Entity;

use App\Repository\OffreEmploisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OffreEmploisRepository::class)]
class OffreEmplois
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['personne_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    #[Groups(['personne_read'])]
    private ?string $Description = null;

    #[ORM\Column(length: 500)]
    #[Groups(['personne_read'])]
    private ?string $Titre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['personne_read'])]
    private ?Profession $Profession = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['personne_read'])]
    private ?\DateTimeInterface $DateOffre = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['personne_read'])]
    private ?PersonneMembre $PersonneMembre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getProfession(): ?Profession
    {
        return $this->Profession;
    }

    public function setProfession(?Profession $Profession): static
    {
        $this->Profession = $Profession;

        return $this;
    }

    public function getDateOffre(): ?\DateTimeInterface
    {
        return $this->DateOffre;
    }

    public function setDateOffre(\DateTimeInterface $DateOffre): static
    {
        $this->DateOffre = $DateOffre;

        return $this;
    }

    public function getPersonneMembre(): ?PersonneMembre
    {
        return $this->PersonneMembre;
    }

    public function setPersonneMembre(?PersonneMembre $PersonneMembre): static
    {
        $this->PersonneMembre = $PersonneMembre;

        return $this;
    }
}

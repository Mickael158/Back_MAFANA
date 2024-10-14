<?php

namespace App\Entity;

use App\Repository\QuiSommeNousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuiSommeNousRepository::class)]
class QuiSommeNous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDebutMondat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFinMondat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PersonneMembre $Personne_Id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profession $Profession_Id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function getDateDebutMondat(): ?\DateTimeInterface
    {
        return $this->DateDebutMondat;
    }

    public function setDateDebutMondat(\DateTimeInterface $DateDebutMondat): static
    {
        $this->DateDebutMondat = $DateDebutMondat;

        return $this;
    }

    public function getDateFinMondat(): ?\DateTimeInterface
    {
        return $this->DateFinMondat;
    }

    public function setDateFinMondat(\DateTimeInterface $DateFinMondat): static
    {
        $this->DateFinMondat = $DateFinMondat;

        return $this;
    }

    public function getPersonneId(): ?PersonneMembre
    {
        return $this->Personne_Id;
    }

    public function setPersonneId(?PersonneMembre $Personne_Id): static
    {
        $this->Personne_Id = $Personne_Id;

        return $this;
    }

    public function getProfessionId(): ?Profession
    {
        return $this->Profession_Id;
    }

    public function setProfessionId(?Profession $Profession_Id): static
    {
        $this->Profession_Id = $Profession_Id;

        return $this;
    }
}

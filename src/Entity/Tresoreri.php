<?php

namespace App\Entity;

use App\Repository\TresoreriRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TresoreriRepository::class)]
class Tresoreri
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $Montant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_tresoreri = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getDateTresoreri(): ?\DateTimeInterface
    {
        return $this->Date_tresoreri;
    }

    public function setDateTresoreri(\DateTimeInterface $Date_tresoreri): static
    {
        $this->Date_tresoreri = $Date_tresoreri;

        return $this;
    }
}

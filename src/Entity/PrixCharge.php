<?php

namespace App\Entity;

use App\Repository\PrixChargeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrixChargeRepository::class)]
class PrixCharge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Charge $IdCharge = null;

    #[ORM\Column]
    private ?float $Valeur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateInsertionPrixCharge = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCharge(): ?Charge
    {
        return $this->IdCharge;
    }

    public function setIdCharge(?Charge $IdCharge): static
    {
        $this->IdCharge = $IdCharge;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->Valeur;
    }

    public function setValeur(float $Valeur): static
    {
        $this->Valeur = $Valeur;

        return $this;
    }

    public function getDateInsertionPrixCharge(): ?\DateTimeInterface
    {
        return $this->DateInsertionPrixCharge;
    }

    public function setDateInsertionPrixCharge(\DateTimeInterface $DateInsertionPrixCharge): static
    {
        $this->DateInsertionPrixCharge = $DateInsertionPrixCharge;

        return $this;
    }
}

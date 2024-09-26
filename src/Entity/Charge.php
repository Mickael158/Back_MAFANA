<?php

namespace App\Entity;

use App\Repository\ChargeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChargeRepository::class)]
class Charge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $NomCharge = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCharge(): ?string
    {
        return $this->NomCharge;
    }

    public function setNomCharge(string $NomCharge): static
    {
        $this->NomCharge = $NomCharge;

        return $this;
    }
}

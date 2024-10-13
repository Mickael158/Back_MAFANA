<?php

namespace App\Entity;

use App\Repository\AproposRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AproposRepository::class)]
class Apropos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Mots = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMots(): ?string
    {
        return $this->Mots;
    }

    public function setMots(string $Mots): static
    {
        $this->Mots = $Mots;

        return $this;
    }
}

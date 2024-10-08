<?php

namespace App\Entity;

use App\Repository\RoleSuspenduRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleSuspenduRepository::class)]
class RoleSuspendu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $Id_Admin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Suspension = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_FinSuspension = null;

    #[ORM\Column(length: 255)]
    private ?string $Role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAdmin(): ?users
    {
        return $this->Id_Admin;
    }

    public function setIdAdmin(?users $Id_Admin): static
    {
        $this->Id_Admin = $Id_Admin;

        return $this;
    }

    public function getDateSuspension(): ?\DateTimeInterface
    {
        return $this->Date_Suspension;
    }

    public function setDateSuspension(\DateTimeInterface $Date_Suspension): static
    {
        $this->Date_Suspension = $Date_Suspension;

        return $this;
    }

    public function getDateFinSuspension(): ?\DateTimeInterface
    {
        return $this->Date_FinSuspension;
    }

    public function setDateFinSuspension(\DateTimeInterface $Date_FinSuspension): static
    {
        $this->Date_FinSuspension = $Date_FinSuspension;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }
}

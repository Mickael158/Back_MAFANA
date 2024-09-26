<?php

namespace App\Entity;

use App\Repository\RefuserDemandeMaterielRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefuserDemandeMaterielRepository::class)]
class RefuserDemandeMateriel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?demandeMateriel $id_demande_materiel = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dates = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $id_utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDemandeMateriel(): ?demandeMateriel
    {
        return $this->id_demande_materiel;
    }

    public function setIdDemandeMateriel(?demandeMateriel $id_demande_materiel): static
    {
        $this->id_demande_materiel = $id_demande_materiel;

        return $this;
    }

    public function getDates(): ?\DateTimeInterface
    {
        return $this->dates;
    }

    public function setDates(\DateTimeInterface $dates): static
    {
        $this->dates = $dates;

        return $this;
    }

    public function getIdUtilisateur(): ?Users
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?Users $id_utilisateur): static
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\RefuserDemandeFinancierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefuserDemandeFinancierRepository::class)]
class RefuserDemandeFinancier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?demandeFinancier $Id_Demande_financier = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dates = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?users $id_utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDemandeFinancier(): ?demandeFinancier
    {
        return $this->Id_Demande_financier;
    }

    public function setIdDemandeFinancier(?demandeFinancier $Id_Demande_financier): static
    {
        $this->Id_Demande_financier = $Id_Demande_financier;

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

    public function getIdUtilisateur(): ?users
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?users $id_utilisateur): static
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }
}
